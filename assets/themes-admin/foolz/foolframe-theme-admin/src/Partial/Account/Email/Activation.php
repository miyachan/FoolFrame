<?php

namespace Foolz\FoolFrame\Theme\Admin\Partial\Account\Email;

class Activation extends \Foolz\FoolFrame\View\View
{
    public function toString()
    { ?>

<h2><?= $this->getParamManager()->getParam('title') ?></h2>

<h4>Hello <?= $this->getParamManager()->getParam('username') ?>!</h4>

Looks like you have succesfully registered with <?= $this->getParamManager()->getParam('site') ?>, and now you need to activate your account! (ﾟДﾟ≡ﾟДﾟ)
<br/><br/>
If this mail was sent to you by mistake, you can just ignore it. Sorry for bothering you! （´・ω・`）
<br/><br/>
Otherwise, you can activate your account by following <strong><a href="<?= $this->getParamManager()->getParam('link') ?>">this link</a></strong>.  ( ゜∀゜)アハハ八八ノヽノヽノヽノ ＼ ／ ＼／ ＼
<br/><br/>
If the link does not work, copy and paste the following address into your browser's address bar: <?= $this->getParamManager()->getParam('link') ?>
<br/><br/><br/>
Thanks for joining us! ｷﾀ━━━━(ﾟ∀ﾟ)━━━━ !!!!! Your registration was VIP quality.
<hr/>
The <?= $this->getParamManager()->getParam('site') ?> team.
<?php
    }
}
