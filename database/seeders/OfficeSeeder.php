<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    public function run(): void
    {
        $offices = [
            [
                'office_name' => "Office of the Municipal Mayor",
                'description' => 'Handles executive and administrative functions of the municipality.',
            ],
            [
                'office_name' => 'Office of the Sangguniang Bayan',
                'description' => 'Legislative body responsible for enacting municipal ordinances.',
            ],
            [
                'office_name' => "Municipal Treasurer's Office",
                'description' => 'Handles collection and management of municipal funds.',
            ],
            [
                'office_name' => "Municipal Accounting Office",
                'description' => 'Handles auditing and recording of financial transactions.',
            ],
            [
                'office_name' => "Municipal Budget Office",
                'description' => 'Prepares and manages the annual municipal budget.',
            ],
            [
                'office_name' => "Municipal Assessor's Office",
                'description' => 'Handles property appraisal and tax assessment.',
            ],
            [
                'office_name' => 'Municipal Planning and Development Office (MPDO)',
                'description' => 'Handles planning, monitoring, and evaluation of development programs.',
            ],
            [
                'office_name' => 'Municipal Engineering Office',
                'description' => 'Handles infrastructure projects and public works.',
            ],
            [
                'office_name' => 'Municipal Human Resource Management Office (HRMO)',
                'description' => 'Handles personnel records and employee management.',
            ],
            [
                'office_name' => 'Municipal Civil Registrar\'s Office',
                'description' => 'Handles birth, marriage, and death registration records.',
            ],
            [
                'office_name' => 'Municipal Social Welfare and Development Office (MSWDO)',
                'description' => 'Handles social welfare programs and community services.',
            ],
            [
                'office_name' => 'Municipal Health Office (MHO)',
                'description' => 'Handles public health services and medical records.',
            ],
            [
                'office_name' => 'Municipal Agriculture Office (MAO)',
                'description' => 'Handles agricultural programs and farmer assistance.',
            ],
            [
                'office_name' => 'Municipal General Services Office',
                'description' => 'Handles procurement, supplies, and general administrative support.',
            ],
            [
                'office_name' => 'Business Permits and Licensing Office (BPLO)',
                'description' => 'Handles business registration and permit issuance.',
            ],
        ];

        foreach ($offices as $office) {
            Office::firstOrCreate(
                ['office_name' => $office['office_name']],
                $office
            );
        }
    }
}