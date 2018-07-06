<?php
/**
 * This source code under MIT license
 *
 * Copyright (c) 2018 Vistar <https://github.com/vistarsvo/>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Vistar\ShellExec;

use yii\base\Component;

/**
 * ShellExec - a component for running console commands in background.
 *
 * Example:
 * \Yii::$app->shellExec->runYiiConsoleAction('controller/action param1 param2 ...' );
 */
class ShellExec extends Component
{
    /**
     * @var string Console application file that will be executed.
     */
    public $file;

    /**
     * @var string The PHP binary path.
     */
    public $phpBinaryPath;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!empty($this->file)) {
            $this->file = \Yii::getAlias($this->file);
        }
    }

    /**
     * @param string $command
     * @return string|null
     */
    public function runShellExec(string $command): ?string
    {
        return shell_exec($command);
    }

    /**
     * Running Yii console command on background.
     *
     * @param string $cmd Argument that will be passed to console application.
     *
     * @return boolean
     */
    public function runYiiConsoleAction(string $cmd): bool
    {
        $cmd = "{$this->phpBinaryPath} {$this->file} $cmd";
        $cmd = $this->isWindows() === true
            ? $cmd = "start /b {$cmd}"
            : $cmd = "{$cmd} > /dev/null 2>&1 &";
        pclose(popen($cmd, 'r'));

        return true;
    }

    /**
     * Check operating system.
     *
     * @return boolean `true` if it's Windows OS.
     */
    protected function isWindows()
    {
        return PHP_OS == 'WINNT' || PHP_OS == 'WIN32';
    }
}
