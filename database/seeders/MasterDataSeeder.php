<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\BranchOffice;
use App\Models\WorkUnit;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create main company
        $company = Company::create([
            'name' => 'PT. Syncore Indonesia',
            'address' => 'Jl. Raya Utama No. 123, Jakarta Pusat',
            'phone' => '021-5551234',
            'email' => 'info@syncore.co.id'
        ]);

        // Create branch offices
        $jakartaBranch = BranchOffice::create([
            'company_id' => $company->id,
            'name' => 'Jakarta Branch',
            'address' => 'Jl. Sudirman No. 45, Jakarta Selatan',
            'phone' => '021-5552345',
            'email' => 'jakarta@syncore.co.id'
        ]);

        $bandungBranch = BranchOffice::create([
            'company_id' => $company->id,
            'name' => 'Bandung Branch',
            'address' => 'Jl. Asia Afrika No. 78, Bandung',
            'phone' => '022-4231234',
            'email' => 'bandung@syncore.co.id'
        ]);

        // Create work units for Jakarta branch
        WorkUnit::create([
            'branch_office_id' => $jakartaBranch->id,
            'name' => 'IT Department',
            'address' => 'Lantai 3, Jakarta Branch Office',
            'phone' => '021-5552345 ext. 301',
            'email' => 'it.jakarta@syncore.co.id'
        ]);

        WorkUnit::create([
            'branch_office_id' => $jakartaBranch->id,
            'name' => 'HR Department',
            'address' => 'Lantai 2, Jakarta Branch Office',
            'phone' => '021-5552345 ext. 201',
            'email' => 'hr.jakarta@syncore.co.id'
        ]);

        // Create work units for Bandung branch
        WorkUnit::create([
            'branch_office_id' => $bandungBranch->id,
            'name' => 'Marketing Department',
            'address' => 'Lantai 2, Bandung Branch Office',
            'phone' => '022-4231234 ext. 201',
            'email' => 'marketing.bandung@syncore.co.id'
        ]);

        WorkUnit::create([
            'branch_office_id' => $bandungBranch->id,
            'name' => 'Finance Department',
            'address' => 'Lantai 1, Bandung Branch Office',
            'phone' => '022-4231234 ext. 101',
            'email' => 'finance.bandung@syncore.co.id'
        ]);
    }
}
