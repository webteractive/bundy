<template>
    <div class="admin">
        <ct class="flex items-center">
            <span class="flex-1">Users</span>

            <div class="text-base">
                <button
                    title="Add New User"
                    class="text-blue-500 hover:text-blue-600"
                    @click="addNew()"
                >
                    <fa icon="user-plus" />
                </button>
            </div>
        </ct>

        <paginator :payload="users" v-slot="{ items }">
            <div
                v-for="user in items"
                :key="user.id"
                class="relative p-4 pl-24 min-h-24 border-b hover:bg-gray-100"
            >
                <user-photo
                    :user="user"
                    size="smaller"
                    class="absolute left-4 top-4 text-2xl"
                />

                <h3 class="flex items-center mb-2">
                    <router-link
                        :title="`Warp to ${user.first_name}'s profile`"
                        :to="`/profile/${user.username}`"
                        v-text="user.name"
                        class="font-bold cursor-pointer hover:underline"
                    />

                    <span
                        v-text="`@${user.username}`"
                        class="text-sm text-gray-500 ml-1"
                    />

                    <span class="text-sm text-black ml-2">·</span>

                    <live-date
                        :date="user.created_at"
                        class="text-sm text-gray-500 ml-2 hover:underline"
                    />
                </h3>

                <div>
                    <user-item
                        v-if="user.email"
                        :value="user.email"
                        label="Email Address"
                    />

                    <user-item
                        v-if="user.role"
                        :value="user.role.name"
                        label="Role"
                    />

                    <user-item
                        v-if="user.address"
                        :value="user.address"
                        label="Address"
                    />

                    <user-item
                        v-if="user.position"
                        :value="user.position"
                        label="Position"
                    />

                    <user-item
                        v-if="user.hired_on"
                        :value="user.hired_on"
                        label="Level"
                    />

                    <user-item
                        v-if="user.level"
                        :value="user.level"
                        label="Level"
                    />
                    
                    <user-item label="Status">
                        <span
                            v-text="user.status_label"
                            :class="{
                                'bg-green-500 text-green-100 px-1 text-xs': user.status_label === 'active',
                                'bg-red-500 text-red-100 px-1 text-xs': user.status_label === 'resigned',
                                'bg-orange-500 text-orange-100 px-1 text-xs': user.status_label === 'suspended',
                            }"
                        />
                    </user-item>
                </div>

                <drop-down
                    :menu="dropDownMenu"
                    @edit="edit(user)"
                    @reset="resetPassword(user)"
                    @resign="updateStatus(user, 'resigned')"
                    @suspend="updateStatus(user, 'suspended')"
                    @activate="updateStatus(user, 'active')"
                    class="absolute top-3 right-4"
                />
            </div>
        </paginator>

        <portal to="modal">
            <admin-user-form
                v-if="shown"
                :user="user"
                @close="close()"
                @success="success()"
            />
        </portal>
    </div>
</template>

<script>
import Confirm from "./Confirm";
import DropDown from "./DropDown";
import Paginator from "./Paginator";
import AdminUserForm from "./AdminUserForm";
import UserItem from './pages/admin/user/UserItem';

export default {
    components: {
        Confirm,
        DropDown,
        UserItem,
        Paginator,
        AdminUserForm
    },

    data () {
        return {
            user: null,
            shown: false
        };
    },

    computed: {
        users () {
            return this.$store.getters["admin/user/pagination"];
        },

        dropDownMenu() {
            return [
                ["edit", "Edit"],
                ["reset", "Reset Password"],
                ["suspend", "Set status as Suspended"],
                ["resign", "Set status as Resigned"],
                ["activate", "Set status as Active"],
                ["delete", "Delete"]
            ];
        }
    },

    methods: {
        fetch () {
            this.$http
                .route("admin.users")
                .get()
                .then(({ data }) => {
                    this.$store.dispatch("admin/user/paginate", data);
                });
        },

        addNew () {
            this.toggleForm(true);
        },

        edit (user) {
            this.toggleForm(true, user);
        },

        toggleForm (shown, payload = null) {
            if (payload !== null) {
                const {
                    id,
                    dob,
                    email,
                    role_id,
                    last_name,
                    first_name
                } = payload;

                this.user = {
                    id,
                    dob,
                    email,
                    role_id,
                    last_name,
                    first_name
                };
            } else {
                this.user = null;
            }

            this.shown = shown;
        },

        close () {
            this.toggleForm(false);
        },

        success () {
            this.fetch();
            this.toggleForm(false);
        },

        resetPassword ({ id, name }) {
            if (confirm(`Are you sure you want to reset ${name}'s password?`)) {
                this.$progress.start();
                this.$http
                    .route("admin.users.password.reset", { id })
                    .post()
                    .then(({ data: { message } }) => {
                        this.$progress.done();
                        this.$bus.emit("successful", { message });
                    });
            }
        },

        updateStatus ({ id }, status) {
            if (confirm('Are you sure you want to set this employee\'s status to be resigned?')) {
                this.$progress.start();
                this.$http
                    .route("admin.users.status.update", { id })
                    .post({ status })
                    .then(({ data: { message } }) => {
                        this.$progress.done();
                        this.$bus.emit("successful", { message });
                        this.fetch();
                    });
            }
        }
    },

    mounted() {
        this.fetch();
    }
};
</script>
