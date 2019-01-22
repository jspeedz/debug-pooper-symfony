<?php
if(!function_exists('getallheaders')) {
    function getallheaders(): array {
        return [
            'X-Some-test-header' => 'somevalue',
        ];
    }
}
