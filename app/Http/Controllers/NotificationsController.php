<?php

namespace App\Http\Controllers;

use App\Bundy\NotificationManager;
use App\Bundy\Response\Notifications;

class NotificationsController extends Controller
{
    public function index()
    {
        return new Notifications();
    }

    public function update(NotificationManager $manager, $id)
    {
        return $manager->markAsRead($id);
    }
    
    public function destroy(NotificationManager $manager, $id)
    {
        return $manager->destroy($id);
    }

    public function updateAll(NotificationManager $manager)
    {
        return $manager->markAllAsRead();
    }

    public function destroyAll(NotificationManager $manager)
    {
        return $manager->destroyAll();
    }
}
