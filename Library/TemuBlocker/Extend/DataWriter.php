<?php

class TemuBlocker_Extend_DataWriter extends XFCP_TemuBlocker_Extend_DataWriter
{
    protected function _discussionPreSave()
    {
        parent::_discussionPreSave();

        // sadece yeni konu oluşturulurken
        if (!$this->isInsert())
        {
            return;
        }

        $visitor = XenForo_Visitor::getInstance();

        // adminleri tamamen hariç tut
        if ($visitor['is_admin'])
        {
            return;
        }

        // sadece 5 mesajdan az kullanıcı
        if ($visitor['message_count'] >= 5)
        {
            return;
        }

        $title = $this->get('title');

        if (!$title)
        {
            return;
        }
      // "t\s*e\s*m\s*u" temu kelimesinin farklı yazılışları için. ilave kelme eklemek için "|" kullanabilirsiniz.
        if (preg_match('/(t\s*e\s*m\s*u|acw274625|code|kampanya)/i', $title))
        {
            $this->error('Yeni üyeler başlıkta bu kelimeyi kullanamaz.', 'title');
        }
    }
}
