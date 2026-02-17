<?php

class TemuBlocker_Listener
{
    public static function loadClass($class, array &$extend)
    {
        if ($class == 'XenForo_DataWriter_Discussion_Thread')
        {
            $extend[] = 'TemuBlocker_Extend_DataWriter';
        }
    }
}
