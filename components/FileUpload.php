<?php


namespace app\components;


use yii\base\DynamicModel;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\UploadedFile;

/**
 * Class FileUpload
 * @package app\components
 */
class FileUpload extends DynamicModel
{
    private $fileName;
    private $uploadDir;
    private $path;
    public $file;

    /**
     * Save file
     *
     * @param string $subDir
     * @param bool $validate
     * @return bool
     * @throws InvalidConfigException
     * @throws \ErrorException
     */
    public function save($subDir, $validate = true)
    {
        // Check file
        if (is_null($this->file)) {
            return false;
        }

        // Validate
        if ($validate === true) {
            $this->validate();
        }

        if (empty($this->uploadDir)) {
            $this->uploadDir = $_SERVER['DOCUMENT_ROOT'];
        }

        if (!($this->file instanceof UploadedFile)) {
            throw new InvalidConfigException("the file must be instance of yii\web\UploadedFile");
        }

        $uploadDir = $this->uploadDir.$subDir;
//        print_r($uploadDir);die;
        if (!is_dir($uploadDir) || !file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = $this->file->extension;
        $file = $this->uploadDir.$this->fileName.'.'.$extension;
        $pathInfo = pathinfo($file);
        if (!is_dir($pathInfo['dirname'])) {
            mkdir($pathInfo['dirname'], 0777, true);
        }
        if($this->file->saveAs($file)){
            $this->path = $this->fileName.'.'.$extension;
            return true;
        }
        if ($this->file->error != UPLOAD_ERR_OK){
            throw  new \ErrorException("Unable to upload file: error code {$this->file->error}");
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $uploadDir
     * @throws Exception
     */
    public function setUploadDir($uploadDir)
    {
        if (!is_string($uploadDir)){
            throw  new Exception("File name must be a string, the: ".gettype($uploadDir)."is given");
        }
        $this->uploadDir = $uploadDir;
    }

    /**
     * @return mixed
     */
    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param $fileName
     * @throws Exception
     */
    public function setFileName($fileName)
    {
        if (!is_string($fileName)) {
            throw  new Exception("File name must be a string, the: ".gettype($fileName)."is given");
        }
        $this->fileName = $fileName;
    }

    /**
     * Generate a human readable size informations from provided Byte/s size
     *
     * @param integer $size The size to convert in Byte
     * @return string The readable size definition
     */
    public function humanReadableFilesize($size)
    {
        $mod = 1024;
        $units = explode(' ', 'B KB MB GB TB PB');
        for ($i = 0; $size > $mod; ++$i) {
            $size /= $mod;
        }

        return round($size, 2).' '.$units[$i];
    }

    /**
     * Create a unique hash name from a given file.
     *
     * Warning
     * Because PHP's integer type is signed many crc32 checksums will result in negative integers on 32bit platforms. On 64bit installations all crc32() results will be positive integers though.
     * So you need to use the "%u" formatter of sprintf() or printf() to get the string representation of the unsigned crc32() checksum in decimal format.
     *
     * @var string $fileName The file name which should be hashed
     * @return string
     */
    public function hashName($fileName)
    {
        return sprintf('%s', hash('crc32b', uniqid($fileName, true)));
    }

    /**
     * Get extension and name from a file for the provided source/path of the file.
     *
     * @param string $sourceFile The path of the file
     * @return object With extension and name keys.
     */
    public function getFileInfo($sourceFile)
    {
        $path = pathinfo($sourceFile);

        return (object) [
            'extension' => (isset($path['extension']) && !empty($path['extension'])) ? mb_strtolower($path['extension'], 'UTF-8') : false,
            'name' => (isset($path['filename']) && !empty($path['filename'])) ? $path['filename'] : false,
            'source' => $sourceFile,
            'sourceFilename' => (isset($path['dirname']) && isset($path['filename'])) ? $path['dirname'] . DIRECTORY_SEPARATOR . $path['filename'] : false,
        ];
    }

    /**
     * Unlink a file, which handles symlinks.
     *
     * @param string $file The file path to the file to delete.
     * @return boolean Whether the file has been removed or not.
     */
    public function unlink($file)
    {
        // no errors should be thrown, return false instead.
        try {
            if (parent::unlink($file)) {
                return true;
            }
        } catch (\Exception $e) {
        }

        // try to force symlinks
        if (is_link($file)) {
            $sym = @readlink($file);
            if ($sym) {
                if (@unlink($file)) {
                    return true;
                }
            }
        }

        // try to use realpath
        if (realpath($file) && realpath($file) !== $file) {
            if (@unlink(realpath($file))) {
                return true;
            }
        }

        return false;
    }
}