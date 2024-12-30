<?php
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
function validate_mobile($phone) {
    $pattern = "/^[6-9][0-9]{9}$/";
    return preg_match($pattern, $phone);
}
function validate_password($password) {
    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";
    return preg_match($pattern, $password);
}
?>