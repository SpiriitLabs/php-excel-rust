<?php

namespace Spiriit\Rustsheet\Structure;

enum CellDataType {
    case ArrayFormula;
    case Blank;
    case Boolean;
    case Error;
    case Formula;
    case Number;
    case DateTime;
    case String;
    case RichString;
}