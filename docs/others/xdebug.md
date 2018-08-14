# XDebug

XDebug for the Editor / IDE

## Requirement

The docker service must started

## VsCode

**Installation**

1. Install the extension named `felixfbecker/vscode-php-debug`

2. Add the following settings in `Debug` => `Open launch.json`

        {
            "version": "0.2.0",
            "configurations": [
                {
                    "name": "Listen for XDebug",
                    "type": "php",
                    "request": "launch",
                    "port": 9000,
                    "pathMappings": {
                        "/slimork": "${workspaceRoot}",
                    },
                    "xdebugSettings": {

                    }
                },
                {
                    "name": "Launch currently open script",
                    "type": "php",
                    "request": "launch",
                    "program": "${file}",
                    "cwd": "${fileDirname}",
                    "port": 9000
                }
            ]
        }

**Profiling**

1. Add the `XDEBUG_PROFILE` in the url like

        http://domain.com/?XDEBUG_PROFILE=1

2. The profiling result will store in the following path

        docker/tmp/php/xdebug/cachegrind.out.*

**Trace**

1. Add the `XDEBUG_TRACE` in the url like

        http://domain.com/?XDEBUG_TRACE=1

2. The trace result will store in the following path

        docker/tmp/php/xdebug/trace.*.xt
