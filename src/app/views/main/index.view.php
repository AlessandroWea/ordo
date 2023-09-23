<style>
    .m1 {
        margin: 1rem;
    }
</style>
<?=$form->start()?>
<div class="m1">
    <?=$form->name?>
</div>
<p><?=$form->error('name')?></p>

<div class="m1">
    <?=$form->price?>
</div>
<p><?=$form->error('price')?></p>

<div class="m1">
    <?=$form->enabled?>
</div>
<p><?=$form->error('enabled')?></p>

<div class="m1">
    <?=$form->type?>
</div>
<p><?=$form->error('type')?></p>

<input type="submit" value="Submit">
<button type="submit">Submit</button>
<?=$form->end()?>

<datalist id="defaultNumbers">
  <option value="10045678"></option>
  <option value="103421"></option>
  <option value="11111111"></option>
  <option value="12345678"></option>
  <option value="12999922"></option>
</datalist