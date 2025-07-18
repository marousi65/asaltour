<?php
declare(strict_types=1);

namespace GCMS\NuSoap;

class WsdlCache
{
    private array  $locks   = [];
    private int    $lifetime;
    private string $cacheDir;
    public  string $debugStr = '';

    public function __construct(string $cacheDir = '.', int $lifetime = 0)
    {
        $this->cacheDir = rtrim($cacheDir, '/');
        $this->lifetime = $lifetime;
    }

    private function filename(string $wsdl): string
    {
        return $this->cacheDir . '/wsdlcache-' . md5($wsdl);
    }

    public function get(string $wsdl): ?object
    {
        $file = $this->filename($wsdl);
        if ($this->lock($file, LOCK_SH)) {
            if ($this->lifetime > 0 && file_exists($file)) {
                if (time() - filemtime($file) > $this->lifetime) {
                    @unlink($file);
                }
            }
            $data = @file_get_contents($file);
            $this->unlock($file);
            return $data !== false ? unserialize($data) : null;
        }
        return null;
    }

    public function put(object $wsdlInstance): bool
    {
        $file = $this->filename($wsdlInstance->wsdl);
        if ($this->lock($file, LOCK_EX)) {
            file_put_contents($file, serialize($wsdlInstance));
            $this->unlock($file);
            return true;
        }
        return false;
    }

    public function remove(string $wsdl): bool
    {
        $file = $this->filename($wsdl);
        $this->lock($file, LOCK_EX);
        $ok = @unlink($file);
        $this->unlock($file);
        return $ok;
    }

    private function lock(string $file, int $mode): bool
    {
        $lockfile = $file . '.lock';
        $fp = fopen($lockfile, 'c');
        if (! $fp) {
            return false;
        }
        if (flock($fp, $mode)) {
            $this->locks[$lockfile] = $fp;
            return true;
        }
        fclose($fp);
        return false;
    }

    private function unlock(string $file): void
    {
        $lockfile = $file . '.lock';
        if (isset($this->locks[$lockfile])) {
            flock($this->locks[$lockfile], LOCK_UN);
            fclose($this->locks[$lockfile]);
            unset($this->locks[$lockfile]);
        }
    }
}
