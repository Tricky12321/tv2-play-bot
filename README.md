# Tv2 Play bot

This is a bot written in php using chromium engine that can log into tv2 play, and remove all devices.

There needs to be created a `config.php` in `src/config.php`.
The file content needs to be as follows:

`````
return [
    "username" => "<email>",
    "password" => "<password>"
];
`````

It will clear all devices every 5 minutes. 
