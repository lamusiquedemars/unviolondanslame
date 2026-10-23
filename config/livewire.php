<?php

return [
    'temporary_file_upload' => [
        // The media library accepts images up to 25 MB. Livewire must permit
        // the same size while it holds the file in its private temporary area.
        'rules' => ['required', 'file', 'max:25600'],
        'max_upload_time' => 10,
    ],
];
