<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        $projects = ['Galle Road Site 102', 'Kandy Hills Residence', 'Colombo Tower Phase 2'];

        foreach ($projects as $name) {
            Project::create(['name' => $name]);
        }

        $expenses = [
            // Galle Road Site 102
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-03-01', 'category' => 'Labor', 'title' => 'Daily labour wages - March week 1', 'amount' => 125000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-03-08', 'category' => 'Concrete and Cement', 'title' => 'Ready-mix concrete delivery', 'amount' => 340000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-03-15', 'category' => 'Steel and Metal', 'title' => 'Rebar reinforcement bars', 'amount' => 215000, 'payment_type' => 'director_paid', 'director_name' => 'Buddhika', 'director_fund_source' => 'bank_balance'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-03-22', 'category' => 'Transport and Logistics', 'title' => 'Sand and aggregate delivery', 'amount' => 48000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-01', 'category' => 'Labor', 'title' => 'Daily labour wages - April week 1', 'amount' => 132000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-05', 'category' => 'Equipment Rental', 'title' => 'Excavator rental - 3 days', 'amount' => 90000, 'payment_type' => 'director_paid', 'director_name' => 'Nilitha', 'director_fund_source' => 'cash_in_hand'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-06', 'category' => 'Electrical and Lighting', 'title' => 'Temporary LED lighting setup', 'amount' => 32500, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-07', 'category' => 'Site Safety and PPE', 'title' => 'Safety helmets and vests (50 units)', 'amount' => 18700, 'payment_type' => 'company_paid'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-07', 'category' => 'Masonry and Blockwork', 'title' => 'Concrete blocks - 5000 units', 'amount' => 87500, 'payment_type' => 'director_paid', 'director_name' => 'Vihaga', 'director_fund_source' => 'bank_balance'],
            ['project_name' => 'Galle Road Site 102', 'expense_date' => '2026-04-07', 'category' => 'Transport and Logistics', 'title' => 'Cement transport - 300 bags', 'amount' => 24000, 'payment_type' => 'company_paid'],

            // Kandy Hills Residence
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-03-05', 'category' => 'Masonry and Blockwork', 'title' => 'Block wall construction - ground floor', 'amount' => 185000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-03-12', 'category' => 'Plumbing and Sanitary', 'title' => 'Underground drainage installation', 'amount' => 76000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-03-20', 'category' => 'MEP Works', 'title' => 'Electrical conduit rough-in', 'amount' => 62000, 'payment_type' => 'director_paid', 'director_name' => 'Vihaga', 'director_fund_source' => 'cash_in_hand'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-02', 'category' => 'Waterproofing and Roofing', 'title' => 'Roof slab waterproofing membrane', 'amount' => 95000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-03', 'category' => 'Doors and Windows', 'title' => 'Aluminum window frames - 12 units', 'amount' => 156000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-04', 'category' => 'Finishing Works', 'title' => 'Interior wall painting - 3000 sqft', 'amount' => 54000, 'payment_type' => 'director_paid', 'director_name' => 'Buddhika', 'director_fund_source' => 'cash_in_hand'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-05', 'category' => 'Concrete and Cement', 'title' => 'Flooring screed mix', 'amount' => 42000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-06', 'category' => 'Labor', 'title' => 'Skilled workers - masonry crew', 'amount' => 145000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Kandy Hills Residence', 'expense_date' => '2026-04-07', 'category' => 'Excavation and Earthwork', 'title' => 'Site clearance and leveling', 'amount' => 78000, 'payment_type' => 'company_paid'],

            // Colombo Tower Phase 2
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-03-10', 'category' => 'Excavation and Earthwork', 'title' => 'Pile driving - columns A1-A8', 'amount' => 520000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-03-18', 'category' => 'Concrete and Cement', 'title' => 'Pile cap concrete pour', 'amount' => 280000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-03-25', 'category' => 'Site Safety and PPE', 'title' => 'PPE equipment for 30 workers', 'amount' => 34500, 'payment_type' => 'director_paid', 'director_name' => 'Buddhika', 'director_fund_source' => 'bank_balance'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-03', 'category' => 'Steel and Metal', 'title' => 'Column reinforcement cages - Level 1', 'amount' => 410000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-06', 'category' => 'Permits and Compliance', 'title' => 'UDA structural inspection fee', 'amount' => 18500, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-07', 'category' => 'Labor', 'title' => 'Tower crane operator & safety crew', 'amount' => 185000, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-07', 'category' => 'Equipment Rental', 'title' => 'Tower crane rental - monthly', 'amount' => 350000, 'payment_type' => 'director_paid', 'director_name' => 'Nilitha', 'director_fund_source' => 'bank_balance'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-07', 'category' => 'MEP Works', 'title' => 'Electrical main panel & cabling', 'amount' => 127500, 'payment_type' => 'company_paid'],
            ['project_name' => 'Colombo Tower Phase 2', 'expense_date' => '2026-04-07', 'category' => 'Plumbing and Sanitary', 'title' => 'Water supply main line installation', 'amount' => 95000, 'payment_type' => 'company_paid'],

            // Additional miscellaneous expenses
            ['project_name' => null, 'expense_date' => '2026-03-30', 'category' => 'Other', 'title' => 'General office supplies', 'amount' => 8500, 'payment_type' => 'company_paid'],
            ['project_name' => null, 'expense_date' => '2026-04-04', 'category' => 'Transport and Logistics', 'title' => 'Fuel for equipment trucks', 'amount' => 12000, 'payment_type' => 'company_paid'],
        ];

        foreach ($expenses as $data) {
            Expense::create(array_merge([
                'director_name' => null,
                'director_fund_source' => null,
                'notes' => null,
                'receipt_path' => null,
            ], $data));
        }
    }
}
