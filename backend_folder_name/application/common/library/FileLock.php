<?php

namespace app\common\library;

class FileLock
{
    static $resource = [];

    public static function lockUp(string $uniqueId): bool
    {
        clearstatcache();

        static::$resource[$uniqueId] = fopen(static::getFilePath($uniqueId), 'w+');
        return flock(static::$resource[$uniqueId], LOCK_EX);
    }

    public static function unLock(string $uniqueId): bool
    {
        clearstatcache();
        if (!isset(static::$resource[$uniqueId])) return false;
        flock(static::$resource[$uniqueId], LOCK_UN);
        fclose(static::$resource[$uniqueId]);
        return static::deleteFile($uniqueId);
    }

    private static function getFilePath(string $uniqueId): string
    {
        clearstatcache();
        $dirPath = RUNTIME_PATH . 'lock/';
        !is_dir($dirPath) && mkdir($dirPath, 0755, true);
        return $dirPath . md5($uniqueId) . '.lock';
    }

    private static function deleteFile(string $uniqueId): bool
    {
        clearstatcache();
        $filePath = static::getFilePath($uniqueId);
        return file_exists($filePath) && unlink($filePath);
    }
}
