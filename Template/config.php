<h3>
    <i class="fa fa-redis fa-fw" aria-hidden="true"></i>
    Redis Cache
</h3>
<div class="panel">
    <?= $this->form->label(t('AWS S3 region'), 'redis_address') ?>
    <?= $this->form->text('redis_address', $values) ?>

    <?= $this->form->label(t('AWS S3 bucket'), 'redis_port') ?>
    <?= $this->form->number('redis_port', $values) ?>

    <?= $this->form->label(t('AWS S3 objects prefix'), 'redis_username') ?>
    <?= $this->form->text('redis_username', $values) ?>

    <?= $this->form->label(t('AWS Access Key ID'), 'redis_password') ?>
    <?= $this->form->password('redis_password', $values) ?>

    <?= $this->form->label(t('AWS Secret Key'), 'redis_database') ?>
    <?= $this->form->number('redis_database', $values) ?>

    <?= $this->form->label(t('AWS S3 custom options'), 'redis_prefix') ?>
    <?= $this->form->text('redis_prefix', $values) ?>

    <p class="form-help"><a href="https://github.com/jackymancs4/plugin-redis-cache#configuration" target="_blank"><?= t('Help on Redis Cache integration') ?></a></p>

    <div class="form-actions">
        <button class="btn btn-blue"><?= t('Save') ?></button>
    </div>
</div>
