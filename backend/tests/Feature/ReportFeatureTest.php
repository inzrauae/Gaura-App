<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ReportFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Project::create(['name' => 'Galle Road Site 102']);
        Project::create(['name' => 'Kandy Hills Residence']);

        Expense::create([
            'expense_date' => '2026-04-07',
            'project_name' => 'Galle Road Site 102',
            'category' => 'Labor',
            'title' => 'Daily labour wages',
            'amount' => 125000,
            'payment_type' => 'company_paid',
        ]);

        Expense::create([
            'expense_date' => '2026-04-06',
            'project_name' => 'Kandy Hills Residence',
            'category' => 'Equipment Rental',
            'title' => 'Excavator rental',
            'amount' => 90000,
            'payment_type' => 'director_paid',
            'director_name' => 'Nilitha',
            'director_fund_source' => 'cash_in_hand',
        ]);
    }

    public function test_reports_page_loads(): void
    {
        $response = $this->get('/reports');

        $response->assertOk();
        $response->assertSee('Reports & Exports', false);
        $response->assertSee('Galle Road Site 102');
    }

    public function test_overall_pdf_report_downloads(): void
    {
        $response = $this->get('/api/reports/download-pdf');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $response->assertHeader('content-disposition');
    }

    public function test_overall_excel_report_downloads_as_real_excel_content_type(): void
    {
        $response = $this->get('/api/reports/download-excel');

        $response->assertOk();
        $response->assertHeader('content-type', 'application/vnd.ms-excel; charset=UTF-8');
        $this->assertStringContainsString('.xls', (string) $response->headers->get('content-disposition'));
        $response->assertSee('<?xml version="1.0"?>', false);
    }

    public function test_project_reports_download_with_encoded_project_name(): void
    {
        $pdfResponse = $this->get('/api/reports/project/' . urlencode('Galle Road Site 102') . '/pdf');
        $excelResponse = $this->get('/api/reports/project/' . urlencode('Galle Road Site 102') . '/excel');

        $pdfResponse->assertOk();
        $pdfResponse->assertHeader('content-type', 'application/pdf');

        $excelResponse->assertOk();
        $excelResponse->assertHeader('content-type', 'application/vnd.ms-excel; charset=UTF-8');
        $excelResponse->assertSee('Galle Road Site 102');
    }

    public function test_store_expense_rejects_invalid_receipt_type(): void
    {
        $response = $this->postJson('/api/expenses', [
            'expense_date' => '2026-04-07',
            'project_name' => 'Galle Road Site 102',
            'category' => 'Labor',
            'title' => 'Invalid upload test',
            'amount' => 5000,
            'payment_type' => 'company_paid',
            'receipt' => UploadedFile::fake()->create('malware.exe', 10, 'application/octet-stream'),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['receipt']);
    }
}