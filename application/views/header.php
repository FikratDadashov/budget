
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Money Lover</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-datepicker3.standalone.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/all.min.css')?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.css')?>">
</head>

<body class="bg-body">


<div class="bg-green text-white">
	<div class="container-fluid pt-3">
		<div class="row">
			<div class="col-md-3">
				<div class="dropdown">
					<button class="btn dropdown-toggle btn-sm bg-green text-white" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="fas fa-user"></span>
						<span><?php echo $email[0]['email']; ?></span>
					</button>

					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="<?php echo base_url('user/logout')?>">Sign out</a>
					</div>
				</div>
			</div>
			<div class="col-md-1 offset-md-8 mt-1">
				<a class="linked"  href="<?php echo base_url('user/today')?>"><span class="fas fa-calendar-alt" title="Jump to today"></span></a>
				<span class="fas fa-question-circle offset-md-3"></span>
			</div>
		</div>
	</div>

	<div class="container mt-3 position-relative">
		<div class="row">
			<div class="offset-md-4 col-md-4 text-center item-hover pt-2 pb-1" data-toggle="modal" data-target=".modal-wallet">
				<span class="fas fa-globe fs-40 d-block"></span>
				<span>All Wallets <span class="fa fa-angle-down"></span></span>
			</div>

			<div class="col-md-6 offset-md-3 mt-2">
				<div class="row text-center">
					<a href="<?php echo base_url('user/previous')?>" class="col item-hover pt-2 pb-2 text-white"><?php 
					
$dateObj   = DateTime::createFromFormat('!m', $this->session->month-1);
$monthName = $dateObj->format('F'); // March
echo $monthName;
?>
	
</a>
					<a href="<?php echo base_url('user/this')?>" class="col item-hover pt-2 pb-2 text-white month-active"><?php 
					
$dateObj   = DateTime::createFromFormat('!m', $this->session->month);
$monthName = $dateObj->format('F'); // March
echo $monthName;
?></a>
					<a href="<?php echo base_url('user/next')?>" class="col item-hover pt-2 pb-2 text-white"><?php 
					
$dateObj   = DateTime::createFromFormat('!m', $this->session->month+1);
$monthName = $dateObj->format('F'); // March
echo $monthName;
?></a>
				</div>
			</div>
		</div>

		<div class="circle text-center" data-toggle="modal" data-target=".modal-transaction">
			<span class="fa fa-plus text-black-50 d-inline-block mt-3"></span>
		</div>
	</div>
	
</div>