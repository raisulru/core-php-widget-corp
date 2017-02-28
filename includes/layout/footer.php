<footer class="panel-footer text-center">Copyright <?php echo date("Y"); ?>, Widget Corp</footer>
</body>
</html>
<?php 
if (isset($connection)) {
	mysqli_close($connection);
}
	
 ?>