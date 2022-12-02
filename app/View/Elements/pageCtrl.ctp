<!--		https://stackoverflow.com/questions/48274414/bootstrap-4-pagination-with-cakephp-2-pagination-helper-->
<div class="d-flex <?php echo ($right) ? 'justify-content-end' : '' ?>">
	<div>
		<ul class="pagination pt-4">
			<?php
			echo $this->Paginator->first(
				'<< ' . __('最初へ'),
				array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'),
				null,
				array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', ' class' =>'page-link'));
			echo $this->Paginator->prev(
				'< ' . __('前へ'),
				array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'),
				null,
				array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', ' class' =>'page-link'));
			echo $this->Paginator->numbers(
				array(
					'separator' => '',
					'currentTag' => 'a',
					'tag' => 'li',
					'class'=>'page-item',
					'currentClass' => 'disabled page-link active',
					' class'=>'page-link',
					'modulus'=>9
				));
			echo $this->Paginator->next(
				__('次へ') . ' >',
				array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'),
				null,
				array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', 'currentClass'=>'page-link', ' class' =>'page-link'));
			echo $this->Paginator->last(
				__('最後へ').' >>',
				array('tag' => 'li', 'class'=>'page-item', ' class'=>'page-link'),
				null,
				array('class' => 'disabled page-item', 'tag' => 'li', 'disabledTag' => 'a', ' class' =>'page-link'));
			?>
		</ul>

		<p class="<?= ($right) ? 'text-right' : '' ?>">
		<?php
		if ($info == true){
			echo $this->Paginator->counter(
				'(#{:start} - #{:end}), {:page} / {:pages} ページ,
				全 {:count} 件'
			);
		}
		?>
		</p>
	</div>

</div>
