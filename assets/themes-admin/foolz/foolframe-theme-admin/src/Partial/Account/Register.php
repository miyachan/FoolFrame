<?php

namespace Foolz\FoolFrame\Theme\Admin\Partial\Account;

class Register extends \Foolz\FoolFrame\View\View
{
    public function toString()
    {
        $form = $this->getForm();
        ?>
        <?= $form->open(['class' => 'form-account', 'onsubmit' => 'fuel_set_csrf_token(this);']) ?>
        <?= $form->hidden('csrf_token', $this->getSecurity()->getCsrfToken()); ?>
        <h2 class="form-account-heading"><?= _i('Register') ?></h2>

        <?= $form->input([
        'class' => 'input-block-level',
        'name' => 'username',
        'value' => $this->getPost('username'),
        'placeholder' => _i('Username'),
        'required' => true
    ]) ?>

        <?= $form->input([
        'class' => 'input-block-level',
        'name' => 'email',
        'value' => $this->getPost('email'),
        'placeholder' => _i('Email Address'),
        'required' => true
    ]) ?>

        <?= $form->password([
        'class' => 'input-block-level',
        'name' => 'password',
        'placeholder' => _i('Password'),
        'required' => true
    ]) ?>

        <?= $form->password([
        'class' => 'input-block-level',
        'name' => 'confirm_password',
        'placeholder' => _i('Confirm Password'),
        'required' => true
    ]) ?>

        <?php if ($this->getPreferences()->get('foolframe.auth.recaptcha2_sitekey', false)) : ?>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('recaptcha_element', {
                    'sitekey' : '<?= $this->getPreferences()->get('foolframe.auth.recaptcha2_sitekey') ?>'
                });
            };
        </script>
        <div id="recaptcha_element"></div><hr>
    <?php endif; ?>

        <?= $form->submit(['class' => 'btn btn-primary', 'name' => 'register', 'value' => _i('Register')]) ?>

        <input type="button" class="btn" onClick="window.location.href='<?= $this->getUri()->create('/admin/account/forgot_password/') ?>'" value="<?= htmlspecialchars(_i('Forgot Password')) ?>" />
        <input type="button" onClick="window.location.href='<?= $this->getUri()->create('/admin/account/login/') ?>'" class="btn" value="<?= htmlspecialchars(_i('Back')) ?>" />
        <?= $form->close() ?>
    <?php
    }
}
