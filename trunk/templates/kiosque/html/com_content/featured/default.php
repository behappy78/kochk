<?php
// no direct access
defined('_JEXEC') or die;
$app = JFactory::getApplication();
//$templateparams =$app->getTemplate(true)->params;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<?php $leadingcount=0 ; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="slide">
	<?php foreach ($this->lead_items as &$item) :
			
				$this->item = &$item;
				echo $this->loadTemplate('item');

			$leadingcount++;
		?>
	<?php endforeach; ?>
</div>
<?php endif; ?>
<?php
	$introcount=(count($this->intro_items));
	$counter=0;
?>
<?php if (!empty($this->intro_items)) : ?>
	<?php foreach ($this->intro_items as $key => &$item) : ?>

	<?php
		$key= ($key-$leadingcount)+1;
		$rowcount=( ((int)$key-1) %	(int) $this->columns) +1;
		$row = $counter / $this->columns ;

		?>
        <div class="slide"">
			<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
			?>
            </div>
		<?php $counter++; ?>
			<?php if (($rowcount == $this->columns) or ($counter ==$introcount)): ?>
				

			<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>


