<?php

namespace App\Bundy;

use App\User as Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\Admin\NewUserCreated;

class UserManager
{
    protected $user;

    protected $model;

    protected $passwordText;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data)
    {
        DB::transaction(function () use ($data) {
            $this->passwordText = Str::random(12);
            $this->user = $this->model->create(array_merge($data, [
                'alias' => $data['first_name'],
                'password' => bcrypt($this->passwordText),
                'email_verified_at' => now()->toDateTimeString(),
                'username' => Str::slug(join(' ', [$data['first_name'], $data['last_name']])),
            ]));
        });

        event(new NewUserCreated($this->user, $this->passwordText));

        return response()->successful([
            'message' => __('messages.admin.user.created', [
                'name' => $this->user->name
            ])
        ]);
    }

    public function update($id, $data)
    {
        DB::transaction(function () use ($id, $data) {
            $this->user = tap($this->model->find($id), function ($user) use ($data) {
                $user->update($data);
            });
        });

        return response()->successful([
            'message' => __('messages.admin.user.updated', [
                'name' => $this->user->name
            ])
        ]);
    }

    public function setStatus($id, $status)
    {
        [$statusId, $message] = [
            'active' => [
                Model::STATUS_ACTIVE,
                'messages.admin.user.status.active'
            ],
            'resigned' => [
                Model::STATUS_RESIGNED,
                'messages.admin.user.status.resigned'
            ],
            'suspended' => [
                Model::STATUS_SUSPENDED,
                'messages.admin.user.status.suspended'
            ]
        ][$status];

        DB::transaction(function () use ($id, $statusId) {
            $this->user = tap($this->model->find($id), function ($user) use ($statusId) {
                $user->update([
                    'status' => $statusId
                ]);
            });
        });

        return response()->successful([
            'message' => __($message, [
                'name' => $this->user->name
            ]),
            'status' => $status,
            'statusId' => $statusId
        ]);
    }
}
