<?php
function activeDashboard()
{
    $uri = service('uri')->getSegment(2);
    if ($uri == null) {
        echo 'class="active"';
    }
}
function activeSidebar($url)
{
    $uri = service('uri')->getSegment(2);
    if (is_array($url)) {
        foreach ($url as $link) {
            if ($uri == $link) {
                echo 'active';
            }
        }
    } else {
        if ($url == $uri) {
            echo 'class="active"';
        }
    }
}
function getSegment($uri)
{
    echo ucfirst(service('uri')->getSegment($uri));
}
function createMyDate($date)
{
    return date_format(date_create($date), 'd F y');
}
function methodField($value)
{
    return "<input type='hidden' name='_method' value='$value' />";
}
function censoredEmail($email)
{
    $count = strlen($email) - 10;
    $censoredEmail = substr_replace($email, str_repeat('*', $count), 4, $count);
    return $censoredEmail;
}
