<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        .header {
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .header .invoice-number {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-box {
            flex: 1;
        }
        .info-box h3 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 14px;
            text-transform: uppercase;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status-paid { background: #27ae60; color: white; }
        .status-unpaid { background: #e74c3c; color: white; }
        .status-partial { background: #f39c12; color: white; }
        .status-draft { background: #95a5a6; color: white; }
        .status-cancelled { background: #34495e; color: white; }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
        }
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .totals-section {
            margin-top: 20px;
            float: right;
            width: 300px;
        }
        .totals-section table {
            margin-bottom: 0;
        }
        .totals-section td {
            padding: 8px 12px;
        }
        .total-row {
            background: #ecf0f1;
            font-weight: bold;
            font-size: 16px;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #7f8c8d;
            font-size: 12px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h1>INVOICE</h1>
                    <p class="invoice-number">#{{ $invoice->id }}</p>
                </div>
                <div style="text-align: right;">
                    <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
                    <p style="margin-top: 10px; font-size: 12px; color: #7f8c8d;">
                        Date: {{ $invoice->invoice_date->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-box">
                <h3>Bill To:</h3>
                <p><strong>{{ $invoice->patient->name }}</strong></p>
                <p>{{ $invoice->patient->phone }}</p>
                @if($invoice->patient->address)
                <p>{{ $invoice->patient->address }}</p>
                @endif
            </div>
            <div class="info-box">
                <h3>Invoice Details:</h3>
                <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
                @if($invoice->due_date)
                <p><strong>Due Date:</strong> {{ $invoice->due_date->format('M d, Y') }}</p>
                @endif
                @if($invoice->doctor)
                <p><strong>Doctor:</strong> {{ $invoice->doctor->user->name }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-center" style="width: 100px;">Quantity</th>
                    <th class="text-right" style="width: 120px;">Unit Price</th>
                    <th class="text-right" style="width: 120px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">₦{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">₦{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals-section">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">₦{{ number_format($invoice->items->sum('total'), 2) }}</td>
                </tr>
                @if($invoice->tax_amount > 0)
                <tr>
                    <td>Tax:</td>
                    <td class="text-right">₦{{ number_format($invoice->tax_amount, 2) }}</td>
                </tr>
                @endif
                @if($invoice->discount_amount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">-₦{{ number_format($invoice->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td>Total Amount:</td>
                    <td class="text-right">₦{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
                @if($invoice->paid_amount > 0)
                <tr style="background: #d5f4e6;">
                    <td>Paid:</td>
                    <td class="text-right">₦{{ number_format($invoice->paid_amount, 2) }}</td>
                </tr>
                <tr style="background: #fff3cd;">
                    <td><strong>Balance Due:</strong></td>
                    <td class="text-right"><strong>₦{{ number_format($invoice->balance, 2) }}</strong></td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div style="clear: both; margin-top: 30px; padding: 15px; background: #f8f9fa; border-left: 4px solid #3498db;">
            <strong>Notes:</strong>
            <p style="margin: 5px 0 0 0;">{{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>This is a computer-generated invoice.</p>
        </div>

        <!-- Print Button (hidden when printing) -->
        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" style="padding: 12px 30px; background: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                Print Invoice
            </button>
            <button onclick="window.close()" style="padding: 12px 30px; background: #95a5a6; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; margin-left: 10px;">
                Close
            </button>
        </div>
    </div>

    <script>
        // Auto-print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
