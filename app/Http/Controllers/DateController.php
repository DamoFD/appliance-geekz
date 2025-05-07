<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;

class DateController extends Controller
{
    private array $yearCodeMap = [
        // Newer
        '0' => 2010, '1' => 2011, '2' => 2012, '3' => 2013, '4' => 2014,
        '5' => 2015, '6' => 2016, '7' => 2017, '8' => 2018, '9' => 2019,
        'X' => 2020, 'A' => 2021, 'B' => 2022, 'C' => 2023, 'D' => 2024, 'E' => 2025,
        // Older fallback (you can reverse-lookup if needed)
        'K' => 2000, 'L' => 2001, 'M' => 2002, 'P' => 2003, 'R' => 2004,
        'S' => 2005, 'T' => 2006, 'U' => 2007, 'W' => 2008, 'Y' => 2009,
    ];

    private array $geMonthCodes = [
        'A' => 1,  'D' => 2,  'F' => 3,
        'G' => 4,  'H' => 5,  'L' => 6,
        'M' => 7,  'R' => 8,  'S' => 9,
        'T' => 10, 'V' => 11, 'Z' => 12,
    ];

    private array $geYearCodes = [
        'F' => [1991, 2003, 2015],
        'G' => [1980, 1992, 2004, 2016],
        'H' => [1981, 1993, 2005, 2017],
        'L' => [1982, 1994, 2006, 2018],
        'M' => [1983, 1995, 2007, 2019],
        'R' => [1984, 1996, 2008, 2020],
        'S' => [1985, 1997, 2009],
        'T' => [1986, 1998, 2010],
        'V' => [1987, 1999, 2011],
        'Z' => [1988, 2000, 2012],
        'A' => [1989, 2001, 2013],
        'D' => [1990, 2002, 2014],
    ];


    public function getGEDate(Request $request)
    {
        $serial = strtoupper($request->input('serial'));

        if (strlen($serial) < 2) {
            return back()->with('error', 'Serial number too short.');
        }

        $monthCode = $serial[0];
        $yearCode = $serial[1];

        if (!isset($this->geMonthCodes[$monthCode]) || !isset($this->geYearCodes[$yearCode])) {
            return back()->with('error', 'Invalid GE serial format.');
        }

        $month = $this->geMonthCodes[$monthCode];
        $possibleYears = $this->geYearCodes[$yearCode];

        // Use latest year as default guess — can refine based on context/model
        $year = max($possibleYears);

        $date = DateTime::createFromFormat('Y-n', "{$year}-{$month}");

        return back()->with('date', "Manufactured: " . $date->format('F Y') . " (Possible years: " . implode(', ', $possibleYears) . ")");
    }

    public function getDate(Request $request)
    {
        $serial = strtoupper($request->input('serial'));

        if (strlen($serial) < 4) {
            return back()->with('error', 'Serial number too short.');
        }

        $yearCode = $serial[1];
        $weekCode = intval(substr($serial, 2, 2));

        if (!isset($this->yearCodeMap[$yearCode]) || $weekCode < 1 || $weekCode > 53) {
            return back()->with('error', 'Invalid serial format.');
        }

        $year = $this->yearCodeMap[$yearCode];
        $date = new DateTime();

        $date->setISODate($year, $weekCode);

        return back()->with('date', "Manufactured week {$weekCode} of {$year}: " . $date->format('Y-m-d'));
    }
}
