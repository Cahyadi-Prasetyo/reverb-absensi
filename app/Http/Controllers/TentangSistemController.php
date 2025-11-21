<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TentangSistemController extends Controller
{
    public function index()
    {
        $technologies = [
            [
                'name' => 'Laravel',
                'description' => 'Framework PHP untuk backend API dan business logic',
                'icon' => 'code',
                'color' => 'red',
            ],
            [
                'name' => 'Redis',
                'description' => 'In-memory database untuk caching dan message broker',
                'icon' => 'database',
                'color' => 'orange',
            ],
            [
                'name' => 'Laravel Reverb',
                'description' => 'WebSocket server untuk real-time communication',
                'icon' => 'bolt',
                'color' => 'yellow',
            ],
            [
                'name' => 'MySQL',
                'description' => 'Relational database untuk penyimpanan data persistent',
                'icon' => 'database-solid',
                'color' => 'blue',
            ],
            [
                'name' => 'Docker Compose',
                'description' => 'Container orchestration untuk deployment terdistribusi',
                'icon' => 'docker',
                'color' => 'cyan',
            ],
            [
                'name' => 'Distributed System',
                'description' => 'Arsitektur terdistribusi dengan load balancing',
                'icon' => 'network',
                'color' => 'purple',
            ],
        ];

        $features = [
            [
                'title' => 'Real-Time Synchronization',
                'description' => 'Data absensi tersinkronisasi secara otomatis dan instan ke semua server menggunakan WebSocket',
                'icon' => 'bolt',
                'color' => 'blue',
            ],
            [
                'title' => 'High Availability',
                'description' => 'Sistem tetap dapat diakses meskipun beberapa server mengalami downtime',
                'icon' => 'server',
                'color' => 'green',
            ],
            [
                'title' => 'Data Consistency',
                'description' => 'Konsistensi data dijaga dengan algoritma distributed consensus',
                'icon' => 'database-solid',
                'color' => 'purple',
            ],
            [
                'title' => 'Secure & Scalable',
                'description' => 'Keamanan data dengan enkripsi dan mudah di-scale sesuai kebutuhan',
                'icon' => 'shield',
                'color' => 'orange',
            ],
        ];

        $architecture = [
            [
                'number' => 1,
                'title' => 'Load Balancer',
                'description' => 'Mendistribusikan traffic ke multiple server instances',
            ],
            [
                'number' => 2,
                'title' => 'Application Servers',
                'description' => 'Multiple Laravel instances untuk handle requests',
            ],
            [
                'number' => 3,
                'title' => 'Redis Cluster',
                'description' => 'Cache layer dan message broker untuk real-time events',
            ],
            [
                'number' => 4,
                'title' => 'Database Replication',
                'description' => 'Master-slave MySQL untuk read scalability',
            ],
            [
                'number' => 5,
                'title' => 'WebSocket Server',
                'description' => 'Laravel Reverb untuk push notifications',
            ],
        ];

        return view('tentang-sistem', compact('technologies', 'features', 'architecture'));
    }
}
