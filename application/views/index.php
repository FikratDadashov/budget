<style >
.error
{
	margin-top: 20px; 
}	
.errors
{
	text-align: center;
	color: #2db84c;
}	
</style>
<div>
	<?php if ($this->session->errorss == 0) : ?>
	<div class="container">
	<?php 
$i=0;$a=array();$b=array();
 foreach($trans as $value) 
{
	$a[$i]= date('d', strtotime( $value['time']));
	if ($value['cat_id']==1){
	$b[$i]=-1*$value['price'];
}
if ($value['cat_id']==2)
{
	$b[$i]=$value['price'];
}

	$i++;

}
$length=$i-1;

for ($i=0; $i < $length; $i++) 
{ 
	for ($j=0; $j < $length; $j++) 
	{
		if ($a[$j]<=$a[$j+1])
		{
			$c=$a[$j];
			$a[$j]=$a[$j+1];
			$a[$j+1]=$c;
		}
	}
}

$i=0;
while ($i <= $length)
{
	while ( $i+1 <= $length && $a[$i] == $a[$i+1]) 
	{
		 
			$g=$i;
			$b[$i]+=$b[$i+1];
			$b[$i+1]=$b[$i];


			while ( $g-1 >= 0 && $a[$g] == $a[$g-1]) 
	{
			$b[$g-1]=$b[$g];
			$g--;

		}
			
			
			$i++;	
	}

	$i++;
}
	$q=0; $m=0; $x=0;
?>

<?php foreach($trans as $value) : ?>
	<?php if ($m==0) : ?>
		<div class="card mx-auto w-40 mt-3 shadow">
		<?php endif;?>
			<?php for ($i=$q; $i < $length+1 ; $i++) : ?>
			
				<?php if ($i==0 || $a[$i] != $a[$i-1]) : $m=0;?>
			<div class="card-header bg-white">
				<div class="row">
					<div class="col-6">
						<span class="fs-30 d-inline-block"><?php echo date('d', strtotime( $value['time'])); ?>
						</span>
						<span class="d-inline-block">
							<span class="d-block fs-10"><?php echo date('D', strtotime( $value['time']));?></span>
							<span class="d-block fs-10 text-secondary"><?php echo date('F Y', strtotime( $value['time']));?></span>
						</span>
					</div>

					<div class="col-6">
						<strong class="float-right mt-2"><?php
					echo $b[$i];
						 ?>
						 </strong>
					</div>
				</div>
			</div>
		<?php endif;?>

				<?php 

				if ( $i<$length && $a[$i] == $a[$i+1] )
				{
					 $m=1;
				}
				else 
				{
					$m=0;
			
				}
					 
					 ?>
		<?php break; endfor; $q++; ?>

			<?php if ($value['cat_id']!=2) : ?>
			<div class="card-body pt-2 pb-2">
				<div class="row item-hover" data-wallet="<?php echo $value['wallet_id'];?>" data-date="<?php echo strtotime($value['time']);?>" data-trans="<?php echo $value['id'] ?>">
					<div class="col-6">
						<span class="fs-30 d-inline-block">
							<span class="<?php echo $value['icon']; ?>"></span>
						</span>
						<span class="d-inline-block ml-2">
							<h5 class="card-title m-0" data-cat="<?php echo $value['subcategory_id']?>" id="js-cat" data-id="<?php echo $value['id'] ?>">
								<?php echo $value['name'];  ?></h5>
							<span class="d-block text-secondary" id="js-note"><?php echo $value['note']; ?></span>
						</span>
					</div>

					<div class="col-6">
						<strong class="float-right mt-2 text-danger" id="js-price"><?php echo $value['price'];?></strong>
					</div>
				</div>
			</div>
		<?php endif;?>


<?php if ($value['cat_id']==2) : ?>
	<div class="card-body pt-2 pb-2">
<div class="row item-hover" data-wallet="<?php echo $value['wallet_id'];?>" data-date="<?php   echo strtotime($value['time']);?>" >
					<div class="col-6 pt-1 pb-1">
						<span class="fs-30 d-inline-block">
							<span class="<?php echo $value['icon']; ?>"></span>
						</span>
						<span class="d-inline-block ml-2">
							<h5 class="card-title m-0" data-cat="<?php echo $value['subcategory_id']?>" id="js-cat"><?php echo $value['name']; ?></h5>
							<span class="d-block text-secondary" id="js-note"><?php echo $value['note']; ?></span>
						</span>
					</div>

					<div class="col-6 pt-1 pb-1">
						<strong class="float-right mt-2 text-primary" id="js-price"><?php echo $value['price']; ?></strong>
					</div>
				</div>
			</div>

<?php endif;?>




	<?php if ($m==0) : ?>

		</div>
	<?php endif;?>


<?php endforeach;?>	

	</div>
<?php endif;?>

<?php if ($this->session->errorss == 1) : ?>
	<div class="error" >

<h5 class="errors">There is no transaction for this month</h5>	
</div>
	<?php endif;?>
</div>