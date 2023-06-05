<?php

namespace Kauffinger\OnOfficeApi\Enums;

enum Language: string
{
    case Albanian = 'ALB';
    case Austrian = 'AUT';
    case Flemish = 'BEL';
    case Bulgarian = 'BGR';
    case Catalan = 'CAT';
    case SwissGerman = 'CHE';
    case Chinese = 'CHN';
    case Czech = 'CZE';
    case German = 'DEU';
    case Danish = 'DNK';
    case English = 'ENG';
    case Spanish = 'ESP';
    case Finnish = 'FIN';
    case French = 'FRA';
    case Greek = 'GRC';
    case Croatian = 'HRV';
    case Hungarian = 'HUN';
    case Italian = 'ITA';
    case Japanese = 'JPN';
    case Korean = 'KOR';
    case Lithuanian = 'LTU';
    case Luxembourgish = 'LUX';
    case Dutch = 'NLD';
    case Norwegian = 'NOR';
    case Polish = 'POL';
    case Portuguese = 'PRT';
    case Romanian = 'ROU';
    case Russian = 'RUS';
    case Arabic = 'SAU';
    case Serbian = 'SRB';
    case Slovenian = 'SVN';
    case Swedish = 'SWE';
    case Turkish = 'TUR';
    case American = 'USA';

    public static function getAllCases(): array
    {
        return array_column(self::cases(), 'value');
    }
}
