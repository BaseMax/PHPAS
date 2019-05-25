# PHP AS(Auto Style), PHP Beautifier

A tool for format and beautify the style of PHP code with my style.

## Story

I developed this tool for myself, not for money, not for a special company.

Although it used in some software of a company in India.

We waste our time to format the code.
So it will be a fantastic tool.

Anyway, I hope this tool can help you for format a PHP code easily and fast.


## Main purpose

- Remove extra space after "for", "while", "if" words...
- Ident cleaning and auto tab for {} and statements...
- Make clean the comment text
- ...

### Demo

Left: Output, Right: Input

![ScreenShot](https://raw.githubusercontent.com/BaseMax/PHPAS/master/screenshot.png)

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

## Partnership and development

Please send issue or pull request if you found a bug or problem.
Feel free to discuss or send pull...

# License

PHPBeautifier is licensed under the [GNU General Public License](LICENSE).
