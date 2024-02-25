<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionAndRolesSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'manage_clients',
            'view_client_information',
            'schedule_appointments',
            'view_appointments',
            'manage_services',
            'view_service_information',
            'receive_appointment_requests',
            'respond_to_appointment_requests',
            'view_revenue',
            'manage_availability',
            'send_notifications',
            'view_reports',
            'manage_blog_content',
            'view_analytics',
            'manage_profile',
            'view_client_feedback',
            'manage_payments',
            'view_consultant_directory',
            'manage_subscriptions',
            'view_training_resources',
            'create_admin', // Permission to create admins
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Define roles and their corresponding permissions
        $roles = [
            'superadmin' => [
                'manage_clients',
                'view_client_information',
                'schedule_appointments',
                'view_appointments',
                'manage_services',
                'view_service_information',
                'receive_appointment_requests',
                'respond_to_appointment_requests',
                'view_revenue',
                'manage_availability',
                'send_notifications',
                'view_reports',
                'manage_blog_content',
                'view_analytics',
                'manage_profile',
                'view_client_feedback',
                'manage_payments',
                'view_consultant_directory',
                'manage_subscriptions',
                'view_training_resources',
                'create_admin', // Permission to create admins
            ],
            
            'admin' => [
                'manage_clients',
                'view_client_information',
                'schedule_appointments',
                'view_appointments',
                'manage_services',
                'view_service_information',
                'receive_appointment_requests',
                'respond_to_appointment_requests',
                'view_revenue',
                'manage_availability',
                'send_notifications',
                'view_reports',
                'manage_blog_content',
                'view_analytics',
                'manage_profile',
                'view_client_feedback',
                'manage_payments',
                'view_consultant_directory',
                'manage_subscriptions',
                'view_training_resources',
            ],
            'consultant' => [
                'view_appointments',
                'receive_appointment_requests',
                'respond_to_appointment_requests',
                'view_revenue',
                'manage_availability',
                'send_notifications',
                'view_profile',
                'view_client_feedback',
                'view_training_resources',
            ],
            'client' => [
                'schedule_appointments',
                'view_appointments',
                'view_services',
                'request_appointments',
                'view_profile',
                'provide_feedback',
                'subscribe_to_newsletter',
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::create(['name' => $roleName]);
            $permissions = Permission::whereIn('name', $rolePermissions)->get();
            $role->syncPermissions($permissions);
        }

        // Create users and assign roles
        $this->createUserWithRole('Super Admin', 'superadmin@example.com', 'password', 'superadmin');
        $this->createUserWithRole('Admin User', 'admin@example.com', 'password', 'admin');
        $this->createUserWithRole('Consultant User', 'consultant@example.com', 'password', 'consultant');
        $this->createUserWithRole('Client User', 'client@example.com', 'password', 'client');
        // Add more users as needed...
    }

    private function createUserWithRole($name, $email, $password, $role)
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $user->assignRole($role);
    }
}
