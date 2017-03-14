<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	$error ="";
	$today=date('Y-m-d');
	$mindata=date('Y-01-01');
	$table='pressione';
	$record=(empty($_REQUEST['id'])) ?  R::dispense($table) : R::load($table, intval($_REQUEST['id']));	
	try {
		if ($record && !empty($_REQUEST['act']) && $_REQUEST['act']=='del') R::trash($record);
		if (!empty($_POST['datamisurazione'])){
			
			
			$diastolica= $_POST['diastolica'];
			$sistolica= $_POST['sistolica'];
			if($diastolica>$sistolica){
				$error = "Errore!";
			}
			
			foreach ($_POST as $k=>$v){
				$record[$k]=$_POST[$k];
			}
			if(!$error)	R::store($record);
		}
	} catch (RedBeanPHP\RedException\SQL $e) {
		?>
		<h4 class="msg label error">
			<?=$e->getMessage()?>
		</h4>
		<?php
	}	
	
	$pa=R::find($table);

?>
<h1 class="w3-container">
		Misurazioni
</h1>
<p><?php echo $error;?></p>
<div class="w3-container">
	<ul class="w3-navbar w3-card-8 w3-light-grey">
		<li><a href="?p=home"> Home </a> </li>
		<li>
			<a href="?p=elenco">
				Storico misurazioni
			</a>
		</li>
	</ul>

<br />
<form action="?p=elenco" method="POST">
	<caption>Nuova misurazione:</caption>
	<input type="date" name="datamisurazione" value="<?=$today?>" max="<?=$today?>" min="<?=$mindata?>" placeholder="data" required />
	<input type="number" name="sistolica" placeholder="sistolica" required />
	<input type="number" name="diastolica" placeholder="diastolica" required />	
	<input type="number" name="peso" placeholder="peso corporeo"/>	
	<button class="w3-btn w3-red w3-text-shadow"><i>Salva</i></button>
</form>

<div>
Visualizza da <input class="dtdt" type="date" />a <input class="dtdt" type="date" /> 
</div>


<table border="1"class="w3-table-all" id="pat">
	<thead>
		<tr class="w3-red">
			<th>
				Data misurazione
			</th>
			<th>
				Sistolica
			</th>		
			<th>
				Diastolica
			</th>
			<th>
				Peso Corporeo
			</th>
			<th>
				&nbsp;
			</th>			
		</tr>
	</thead>
	<tbody>
	<?php foreach ($pa as $i) : ?>
		<tr>
			<td>
			
			<?php $datamisurazione = $i->datamisurazione ;
				
				echo date('d/m/Y',strtotime("$datamisurazione"));
				
				?>
			</td> 
			<td>
				<?=$i->sistolica?> 
			</td> 
			<td>
				<?=$i->diastolica?>
			</td>
			<td>
				<?=$i->peso?>
			</td>
			<td>
				<a href="?p=elenco&act=del&id=<?=$i->id?>" title="elimina questa rilevazione">x</a>
			</td>			
		</tr>
		
	<?php endforeach; ?>
</tbody>
<tfoot>
    <tr class="w3-red">
	<td>
	</td>
      <td>Valore medio: 
		<?php $NumSist=R::getCell( 'Select Avg(sistolica) as Medio from pressione' );
		echo $NumSist = number_format($NumSist, 0, ',', '');
		?> 
	</td>
      <td>Valore medio: 
			<?php $NumDiast=R::getCell( 'Select Avg(diastolica)as Medio from pressione' );
			echo $NumDiast = number_format($NumDiast, 0, ',', '');
			?> 
	</td>
	  <td>
	</td>
	<td>
	</td>
    </tr>
  </tfoot>
</table>
</div>