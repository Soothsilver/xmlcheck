<?php
var_dump(filter_var('email@123.123.123.123', FILTER_VALIDATE_EMAIL));
var_dump(filter_var('email@111.222.333.44444', FILTER_VALIDATE_EMAIL));