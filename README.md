# PHP Beautifier

A tool for format and beautify the style of PHP code with my style.

### Input

```php
<?php
/* dfgdgdf gdfg */
for ($v = 7;$v <= 100 / 10;$v++) {
$b = $v;
$x = [];
for ($i = 1;$i <= $v;$i++) {
$x[] = $i;
}
for ($k = 3;$k <= ((floor($v - 1) / 2) + 1);$k++) {
$r = $k;
solve($x, $v, $b, $k, $r);
}
}
```


### Result

```php
<?php
/* dfgdgdf gdfg */
for($v=7;$v<=100/10;$v++) {
	$b=$v;
	$x=[];
	for($i=1;$i<=$v;$i++) {
		$x[]=$i;
	}

	for($k=3;$k<=((floor($v-1)/2)+1);$k++) {
		$r=$k;
		solve($x,$v,$b,$k,$r);
	}

}
```


-------------------

### Input

```php
<?php
/*      	 	 	 dfgdgdf gdfg */
for ($v = 7;$v <= 100 / 10;$v++) { $b = $v; $x = []; for ($i = 1;$i <= $v;$i++) {$x[] = $i;
}
for ($k = 3;$k <= ((floor($v - 1) / 2) + 1);$k++) { $r = $k;
solve($x, $v, $b, $k, $r); } }
$str="hello world!";
```

### Output

```php
<?php
/* dfgdgdf gdfg */
for($v = 7;$v <= 100 / 10;$v++) {
	$b=$v;
	$x=[];
	for($i = 1;$i <= $v;$i++) {
		$x[]=$i;
	}

	for($k = 3;$k <= ((floor($v - 1) / 2) + 1);$k++) {
		$r=$k;
		solve($x, $v, $b, $k, $r);
	}
}

$str="hello world!";
```
