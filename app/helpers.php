<?php

function isEmpty($param)
{
    if ($param == '' || is_null($param)) {
        return true;
    }
    return false;
}
