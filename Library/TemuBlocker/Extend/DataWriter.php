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

        // sadece 10 mesajdan az kullanıcı
        if ($visitor['message_count'] >= 10)
        {
            return;
        }

        $title = $this->get('title');

        if (!$title)
        {
            return;
        }
        if (preg_match('/(t\s*e\s*m\s*u|acw274625|code|kampanya|Gutschein|acu729640|T_e_m_u)/i', $title)) // Başlığa yazılacak yasaklı kelimeleri aralarına "|" işareti koyarak ekliyoruz.
        {
            // ölüm vuruşu modu
            $userDw = XenForo_DataWriter::create('XenForo_DataWriter_User');
            $userDw->setExistingData($visitor['user_id']);
            // yıldırılan kullanıcı yap
            $userDw->set('is_discouraged', 1);
            // group değiştir (Yasaklı : 6)
            $userDw->set('user_group_id', 6);
            $userDw->save();
            // Uyarı mesajı
            $this->error('Spam tespit edildi. Hesabınız kısıtlandı.', 'title');

        }
    }
}
