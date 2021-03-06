<template>
    <modal v-if="shown" disable-close-button>
        <div
            :class="{
                'md:w-600': scheduled,
                'md:w-500': unscheduled
            }"
            class="bg-white w-screen h-screen md:h-auto relative z-20 shadow"
        >
            <ct>{{ unscheduled ? "Setup" : "Change" }} Schedules</ct>

            <error-manager
                :error="error"
                v-slot="{
                    hasError,
                    getErrorFor
                }"
            >
                <div>
                    <div class="px-4 pt-4 pb-2">
                        <div class="flex flex-wrap">
                            <div
                                v-for="name in fields"
                                :key="name"
                                :class="{
                                    'w-1/2': scheduled,
                                    'w-full': unscheduled,
                                    'pr-2': odd(name),
                                    'pl-2': !odd(name)
                                }"
                            >
                                <field
                                    :select-options="schedules"
                                    :name="name"
                                    v-model="form[name]"
                                    type="select"
                                    class="mb-4"
                                >
                                    <label
                                        :for="name"
                                        :class="{
                                            'flex items-center': scheduled
                                        }"
                                        slot="label"
                                        class="block mb-1 text-base"
                                    >
                                        <span v-text="name.capitalize()" />
                                        <span
                                            v-if="getCurrentScheduleByDay(name)"
                                            v-text="
                                                `(${getCurrentScheduleByDay(name)})`
                                            "
                                            :title="
                                                `You current schedule for this day is ${getCurrentScheduleByDay(
                                                    name
                                                )}`
                                            "
                                            class="font-bold text-sm ml-2 hover:underline"
                                        />
                                    </label>
                                </field>
                            </div>
                        </div>

                        <field
                            :has-error="hasError('reason')"
                            :errors="getErrorFor('reason')"
                            label="Reason"
                            v-model="form.reason"
                            type="textarea"
                            class="mb-4"
                        />
                    </div>

                    <div class="px-4 py-3 border-t">
                        <the-button
                            v-if="unscheduled"
                            :loading="saving"
                            @click="submit()"
                            type="info"
                            label="Save Schedules"
                        />

                        <the-button
                            v-if="scheduled"
                            :loading="saving"
                            @click="update()"
                            type="info"
                            label="Send Request"
                        />

                        <the-button
                            v-if="scheduled"
                            :disabled="saving"
                            @click="close()"
                            label="Cancel"
                        />
                    </div>
                </div>
            </error-manager>
        </div>
    </modal>
</template>

<script>
import merge from "lodash.merge";
import { mapGetters } from "vuex";
import formatDate from "date-fns/format";
import ErrorManager from "./ErrorManager";

export default {
    data() {
        return {
            error: null,
            shown: false,
            saving: false,
            form: {
                monday: 5,
                tuesday: 5,
                wednesday: 5,
                thursday: 5,
                friday: 5,
                saturday: 6,
                reason: ""
            }
        };
    },

    computed: {
        ...mapGetters({
            scheduled: "user/scheduled",
            unscheduled: "user/unscheduled"
        }),

        fields () {
            return Object.keys(this.form).filter(field => field !== "reason");
        },

        schedules () {
            const schedules = this.$store.getters.schedules;
            return schedules.map(schedule => {
                const text = [
                    formatDate(schedule.start_date_at, "h:mm A"),
                    formatDate(schedule.end_date_at, "h:mm A")
                ].join(" - ");

                return {
                    text,
                    value: schedule.id
                };
            });
        },

        daysOfTheWeek () {
            return {
                sunday: 0,
                monday: 1,
                tuesday: 2,
                wednesday: 3,
                thursday: 4,
                friday: 5,
                saturday: 6
            };
        }
    },

    methods: {
        toggleSaving (saving) {
            this.saving = saving;
            if (saving) {
                this.$progress.start();
            } else {
                this.$progress.done();
            }
        },

        submit () {
            this.toggleSaving(true);
            this.$http
                .route("schedules.store")
                .post(this.form)
                .then(({ data: { user } }) => {
                    this.$store.dispatch("user/hydrate", user);
                    this.toggleSaving(false);
                })
                .catch(error => {
                    this.error = error.response.data;
                    this.toggleSaving(false);
                });
        },

        update () {
            this.toggleSaving(true);
            this.$http
                .route("schedules.update")
                .post(this.form)
                .then(({ data: { message } }) => {
                    this.$bus.emit("successful", { message });
                    this.toggleSaving(false);
                    this.close();
                })
                .catch(error => {
                    this.error = error.response.data;
                    this.toggleSaving(false);
                });
        },

        toggle (shown) {
            this.shown = shown;
        },

        open () {
            const { schedules } = this.$store.getters["user/details"];

            for (const field in this.form) {
                const dayAsNumber = this.daysOfTheWeek[field];

                if (typeof dayAsNumber !== "undefined") {
                    const schedule = schedules.find(
                        item => item.details.day === dayAsNumber
                    );
                    if (typeof schedule !== "undefined") {
                        this.form[field] = schedule.id;
                    }
                }
            }

            this.toggle(true);
        },

        close () {
            this.error = null
            this.toggle(false);
        },

        odd (day) {
            return ["monday", "wednesday", "friday"].includes(day);
        },

        getCurrentScheduleByDay (day) {
            if (this.unscheduled) {
                return null;
            }

            const dayAsNumber = this.daysOfTheWeek[day];
            const { schedules } = this.$store.getters["user/details"];
            const schedule = schedules.find(
                schedule => schedule.details.day === dayAsNumber
            );

            if (typeof schedule === "undefined") {
                return null;
            }

            return [
                formatDate(schedule.start_date_at, "h:mm A"),
                formatDate(schedule.end_date_at, "h:mm A")
            ].join(" - ");
        }
    },

    mounted () {
        this.toggle(this.unscheduled);
        this.$bus.on("schedule.change", () => this.open());
    }
};
</script>