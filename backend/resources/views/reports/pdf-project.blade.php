<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAURA - {{ $projectName }} Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9fafb;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #003d9b;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #003d9b;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: #785a00;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }
        .summary-card {
            background-color: #f0f4f8;
            padding: 20px;
            border-radius: 6px;
            border-left: 4px solid #003d9b;
        }
        .summary-card.gold {
            border-left-color: #785a00;
        }
        .summary-card h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #003d9b;
        }
        .summary-card.gold .value {
            color: #785a00;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h2 {
            color: #003d9b;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 2px solid #003d9b;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #003d9b;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $projectName }} - Expense Report</h1>
            <p>Generated on {{ $generatedDate }}</p>
        </div>

        <div class="summary">
            <div class="summary-card">
                <h3>Total Expenses</h3>
                <div class="value">{{ $expenses->count() }}</div>
            </div>
            <div class="summary-card gold">
                <h3>Total Amount</h3>
                <div class="value">LKR {{ number_format($totalAmount, 2) }}</div>
            </div>
            <div class="summary-card">
                <h3>Company Paid</h3>
                <div class="value">LKR {{ number_format($totalCompanyPaid, 2) }}</div>
            </div>
            <div class="summary-card gold">
                <h3>Director Paid</h3>
                <div class="value">LKR {{ number_format($totalDirectorPaid, 2) }}</div>
            </div>
        </div>

        @if($byCategory->count() > 0)
        <div class="section">
            <h2>Summary by Category</h2>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th class="text-right">Expenses</th>
                        <th class="text-right">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($byCategory as $category => $data)
                    <tr>
                        <td>{{ $category }}</td>
                        <td class="text-right">{{ $data['count'] }}</td>
                        <td class="text-right">LKR {{ number_format($data['total'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="section">
            <h2>All Expenses</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th class="text-right">Amount</th>
                        <th>Payment Type</th>
                        <th>Director</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>
                        <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->title }}</td>
                        <td class="text-right">LKR {{ number_format($expense->amount, 2) }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $expense->payment_type)) }}</td>
                        <td>{{ $expense->director_name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #999;">No expenses found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>This is an automatically generated report from GAURA Construction Cost Tracking System</p>
        </div>
    </div>
</body>
</html>
