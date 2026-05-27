<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use App\Models\Mobil;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ReportController extends Controller
{
    public function index()
    {
        $query = Transaksi::query();
        $summaryQuery = Transaksi::query();
        $pembayaranQuery = Pembayaran::query();

        // Apply filters
        $startDate = request('start_date');
        $endDate = request('end_date');
        $status = request('status');
        $search = request('search');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
            $summaryQuery->whereDate('created_at', '>=', $startDate);
            $pembayaranQuery->whereDate('tgl_bayar', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
            $summaryQuery->whereDate('created_at', '<=', $endDate);
            $pembayaranQuery->whereDate('tgl_bayar', '<=', $endDate);
        }
        if ($status) {
            $query->where('status_transaksi', $status);
            $summaryQuery->where('status_transaksi', $status);
            $pembayaranQuery->whereHas('transaksi', function($q) use($status) {
                $q->where('status_transaksi', $status);
            });
        }
        if ($search) {
            $query->where(function($q) use($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('status_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function($q2) use($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function($q2) use($search) {
                      $q2->where('merk', 'like', "%{$search}%")
                         ->orWhere('model', 'like', "%{$search}%");
                  });
            });
            $summaryQuery->where(function($q) use($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('status_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function($q2) use($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function($q2) use($search) {
                      $q2->where('merk', 'like', "%{$search}%")
                         ->orWhere('model', 'like', "%{$search}%");
                  });
            });
            $pembayaranQuery->whereHas('transaksi', function($q) use($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function($q2) use($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function($q2) use($search) {
                      $q2->where('merk', 'like', "%{$search}%")
                         ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        // Calculate summary cards
        if (!$startDate && !$endDate) {
            // Default to current month stats
            $totalPenjualan = (clone $summaryQuery)->whereIn('status_transaksi', ['Lunas', 'Mobil Diambil / Dikirim', 'Transaksi Selesai'])
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();

            $totalPendapatan = (clone $pembayaranQuery)->where('status_verifikasi', 'Valid')
                ->whereMonth('tgl_bayar', now()->month)
                ->whereYear('tgl_bayar', now()->year)
                ->sum('jumlah_bayar');
        } else {
            // Range stats
            $totalPenjualan = (clone $summaryQuery)->whereIn('status_transaksi', ['Lunas', 'Mobil Diambil / Dikirim', 'Transaksi Selesai'])
                ->count();

            $totalPendapatan = (clone $pembayaranQuery)->where('status_verifikasi', 'Valid')
                ->sum('jumlah_bayar');
        }

        $rataRata = $totalPenjualan > 0 ? $totalPendapatan / $totalPenjualan : 0;

        $transaksis = $query->with(['pembeli.user', 'mobil', 'pembayarans'])
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reports', [
            'activePage' => 'reports',
            'pageTitle' => 'Laporan Transaksi',
            'totalPenjualan' => $totalPenjualan,
            'totalPendapatan' => $totalPendapatan,
            'rataRata' => $rataRata,
            'transaksis' => $transaksis,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'search' => $search,
            ]
        ]);
    }

    public function export()
    {
        $query = Transaksi::with(['pembeli.user', 'mobil', 'pembayarans']);

        // Apply filters
        $startDate = request('start_date');
        $endDate = request('end_date');
        $status = request('status');
        $search = request('search');

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        if ($status) {
            $query->where('status_transaksi', $status);
        }
        if ($search) {
            $query->where(function($q) use($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('status_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('pembeli', function($q2) use($search) {
                      $q2->where('nama_lengkap', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function($q2) use($search) {
                      $q2->where('merk', 'like', "%{$search}%")
                         ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        $transaksis = $query->orderBy('created_at', 'desc')->get();

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Transaksi');

        // Ensure gridlines are visible
        $sheet->setShowGridlines(true);

        // Header style (Navy Theme)
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E3A8A'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB'],
                ],
            ],
        ];

        // Summary Card Style
        $summaryLabelStyle = [
            'font' => [
                'bold' => true,
                'size' => 10,
                'color' => ['rgb' => '4B5563'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F3F4F6'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'],
                ],
            ],
        ];

        $summaryValueStyle = [
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => '1E3A8A'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'EFF6FF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'BFDBFE'],
                ],
            ],
        ];

        // Title Block
        $sheet->setCellValue('A1', 'DRIVEHUB - LAPORAN TRANSAKSI');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16)->setColor(new Color('1E3A8A'));
        
        $periodeText = 'Semua Waktu';
        if ($startDate && $endDate) {
            $periodeText = date('d M Y', strtotime($startDate)) . ' s/d ' . date('d M Y', strtotime($endDate));
        } elseif ($startDate) {
            $periodeText = 'Mulai ' . date('d M Y', strtotime($startDate));
        } elseif ($endDate) {
            $periodeText = 'Hingga ' . date('d M Y', strtotime($endDate));
        }
        $sheet->setCellValue('A2', 'Periode: ' . $periodeText);
        $sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new Color('4B5563'));
        
        $sheet->setCellValue('A3', 'Tanggal Unduh: ' . date('d M Y H:i:s'));
        $sheet->getStyle('A3')->getFont()->setSize(9)->setColor(new Color('6B7280'));

        // Calculate statistics
        $totalTrx = $transaksis->count();
        $totalRev = $transaksis->whereIn('status_transaksi', ['Lunas', 'Mobil Diambil / Dikirim', 'Transaksi Selesai'])->sum('total_harga');
        $avgVal = $totalTrx > 0 ? $totalRev / $totalTrx : 0;

        // Summary Row labels (Row 5)
        $sheet->setCellValue('A5', 'TOTAL PENJUALAN');
        $sheet->setCellValue('B5', 'TOTAL PENDAPATAN');
        $sheet->setCellValue('C5', 'RATA-RATA NILAI TRANSAKSI');
        $sheet->getStyle('A5:C5')->applyFromArray($summaryLabelStyle);
        $sheet->getRowDimension(5)->setRowHeight(20);

        // Summary Row values (Row 6)
        $sheet->setCellValue('A6', $totalTrx);
        $sheet->setCellValue('B6', $totalRev);
        $sheet->setCellValue('C6', $avgVal);
        $sheet->getStyle('A6:C6')->applyFromArray($summaryValueStyle);
        $sheet->getStyle('B6')->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getStyle('C6')->getNumberFormat()->setFormatCode('"Rp "#,##0');
        $sheet->getRowDimension(6)->setRowHeight(26);

        // Table Headers (Row 8)
        $headersList = ['ID Transaksi', 'Pelanggan', 'Mobil', 'Total Harga', 'Tanggal Transaksi', 'Status Transaksi'];
        foreach ($headersList as $colIndex => $headerText) {
            $colLetter = chr(65 + $colIndex); // A, B, C, D, E, F
            $sheet->setCellValue($colLetter . '8', $headerText);
        }
        $sheet->getStyle('A8:F8')->applyFromArray($headerStyle);
        $sheet->getRowDimension(8)->setRowHeight(28);

        // Populate Data (Starting Row 9)
        $row = 9;
        foreach ($transaksis as $trx) {
            $sheet->setCellValue('A' . $row, '#TRX-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT));
            $sheet->setCellValue('B' . $row, $trx->pembeli->nama_lengkap ?? '-');
            $sheet->setCellValue('C' . $row, ($trx->mobil->merk ?? '') . ' ' . ($trx->mobil->model ?? ''));
            $sheet->setCellValue('D' . $row, $trx->total_harga);
            $sheet->setCellValue('E' . $row, $trx->created_at->format('d M Y H:i'));
            $sheet->setCellValue('F' . $row, $trx->status_transaksi);

            // Formatting Price column as Rupiah currency
            $sheet->getStyle('D' . $row)->getNumberFormat()->setFormatCode('"Rp "#,##0');

            // Alignments
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Zebra Striping & Borders
            $rowStyle = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E5E7EB'],
                    ],
                ],
            ];
            
            if ($row % 2 == 0) {
                $rowStyle['fill'] = [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'F9FAFB'],
                ];
            }
            $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($rowStyle);

            // Status Badge Styling in Sheet
            $status = $trx->status_transaksi;
            $statusCell = 'F' . $row;
            if ($status == 'Lunas' || $status == 'Transaksi Selesai' || $status == 'Mobil Diambil / Dikirim') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['color' => ['rgb' => '047857'], 'bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D1FAE5'],
                    ]
                ]);
            } elseif ($status == 'Dibatalkan') {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['color' => ['rgb' => 'B91C1C'], 'bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FEE2E2'],
                    ]
                ]);
            } elseif (str_contains($status, 'Menunggu') || str_contains($status, 'Pending')) {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['color' => ['rgb' => 'B45309'], 'bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FEF3C7'],
                    ]
                ]);
            } else {
                $sheet->getStyle($statusCell)->applyFromArray([
                    'font' => ['color' => ['rgb' => '1D4ED8'], 'bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'DBEAFE'],
                    ]
                ]);
            }

            $sheet->getRowDimension($row)->setRowHeight(22);
            $row++;
        }

        // Auto-fit Columns (A to F)
        foreach (range('A', 'F') as $colLetter) {
            $sheet->getColumnDimension($colLetter)->setAutoSize(true);
        }

        // Set Headers and Stream Output
        $fileName = 'laporan-transaksi-' . date('Y-m-d') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $writer->save('php://output');
        exit;
    }
}

