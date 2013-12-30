<?php
include __DIR__ . '/common.php';

// Create worker class and bind the inbound address to 'THUMBNAIL_ADDR' and connect outbound to 'COLLECTOR_ADDR'
$worker = new Worker (THUMBNAIL_ADDR, COLLECTOR_ADDR);

// Register our thumbnail callback, nothing special here
$worker->register ('thumbnail', function ($filename, $width, $height) {
                                    $info = pathinfo ($filename);

                                    $out = sprintf ("%s/%s_%dx%d.%s",
                                                    $info ['dirname'],
                                                    $info ['filename'],
                                                    $width,
                                                    $height,
                                                    $info ['extension']);

                                    $status = 1;
                                    $message = '';

                                    try {
                                        $im = new Imagick ($filename);
                                        $im->thumbnailImage ($width, $height);
                                        $im->writeImage ($out);
                                    }
                                    catch (Exception $e) {
                                        $status = 0;
                                        $message = $e->getMessage ();
                                    }

                                    return array (
                                                'status'    => $status,
                                                'filename'  => $filename,
                                                'thumbnail' => $out,
                                                'message'   => $message,
                                        );
                                });

// Run the worker, will block
echo "Running thumbnail worker.." . PHP_EOL;
$worker->work ();
