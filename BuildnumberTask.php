<?php
/*
 * $Id:  $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */
require_once 'phing/Task.php';

/**
 * Buildnumber Task
 *
 * Increments a number from a given file
 * and writes it back to the file.
 * Resulting number is also published under supplied property.
 *
 * @author      Mike Wittje <mw@mike.wittje.de> modified by Sven Schultschik (sven@schultschik.de)
 * @version     $Id: $
 * @package     phing.tasks.ext
 */
class BuildnumberTask extends Task
{
   /**
     * Property for File
     * @var PhingFile file
     */
    private $file;

    /**
     * Property to be set
     * @var string $property
     */
    private $property;

    /**
     * Set Property for File containing versioninformation
     * @param PhingFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set
     * @param $property
     * @return
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }

    /**
     * Main-Method for the Task
     *
     * @return  void
     * @throws  BuildException
     */
    public function main()
    {
        // check supplied attributes
        $this->checkFile();
        $this->checkProperty();

        // read file
        $filecontent = trim(file_get_contents($this->file));

        // get new version
        $newVersion = $this->getVersion($filecontent);

        // write new Version to file
        file_put_contents($this->file, "#Build Number for PHING. Do not edit! \n" .$newVersion . "\n");

        // publish new version number as property
        $this->project->setProperty($this->property, $newVersion);

    }

    /**
     * Returns new build number
     *
     * @param string $filecontent
     * @return string
     */
    private function getVersion($filecontent)
    {
        // init
        $newVersion = '';

        // Extract version
        $content = explode("\n", $filecontent);
        // Return new version number
        foreach ($content as $value) {
		if (substr($value,0,1) != '#') {
			$newVersion = (int)$value + 1;
		}
	}           
        return $newVersion;
    }


    /**
     * checks file attribute
     * @return void
     * @throws BuildException
     */
    private function checkFile()
    {
        // check File
        if ($this->file === null ||
        strlen($this->file) == 0) {
	    throw new BuildException('You must specify a file containing the version number', $this->location);
        }

        $content = file_get_contents($this->file);
        if (strlen($content) == 0) {
            throw new BuildException(sprintf('Supplied file %s is empty', $this->file), $this->location);
        }
    }

    /**
     * checks property attribute
     * @return void
     * @throws BuildException
     */
    private function checkProperty()
    {
        if (is_null($this->property) ||
            strlen($this->property) === 0) {
            throw new BuildException('Property for publishing version number is not set', $this->location);
        }
    }
}

