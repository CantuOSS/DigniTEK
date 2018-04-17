<!-- File: src/Template/Articles/view.ctp -->

<h1><?= h($article->titulo) ?></h1>
<p><?= h($article->contenido) ?></p>
<p><small>Created: <?= $article->fecha->format(DATE_RFC850) ?></small></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?></p>