# PHP AS(Auto Style), PHP Beautifier

A tool for format and beautify the style of PHP code with my style.

## Purpose

We waste our time to format the code.
So it will be a fantastic tool.

Anyway, I hope this tool can help you for format a PHP code easily and fast.

## Story

I developed this tool for myself, not for money, not for a special company.

Although it used in some software of a company in India.

Also it used as PHP snippet formate on [PHPize.online](https://phpize.online)


## Main purpose

- Remove extra space after "for", "while", "if" words...
- Ident cleaning and auto tab for {} and statements...
- Make clean the comment text
- ...

### Demo

Left: Output, Right: Input

![ScreenShot](https://raw.githubusercontent.com/BaseMax/PHPAS/master/screenshot.png)

### Usage

```php
<?php
/* Include Class */
include "PHPAS.php"

/* Create Class Instance with default options */
$autoStyle = new AutoStyle();

/* or with optional configuratoin */
$options = [
	'identation' => '    ' // 4 spaces (default Tab)
];

$autoStyle = new AutoStyle($options);

/* Format code from file */
print $AS->loadFile("test.php") ."\n";

/* Format code from string */
print $AS->loadString("<?php\nprint 'hi';\n") ."\n";
```

### Class Methods

| Method        			| Goal |
| ------------------------- | ------------- |
| setOptions($options) 		| Change formatter options... 	|
| loadFile($fileName)  		| Auto Style, format a file and display output... |
| loadString($codeString)	| Auto Style, format a string code and display output... |

### Input

```php
<?php
/* inline comment */
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

### Output

```php
<?php
/* inline comment */
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
/*      	 	 	 inline comment */
for ($v = 7;$v <= 100 / 10;$v++) { $b = $v; $x = []; for ($i = 1;$i <= $v;$i++) {$x[] = $i;
}
for ($k = 3;$k <= ((floor($v - 1) / 2) + 1);$k++) { $r = $k;
solve($x, $v, $b, $k, $r); } }
$str="hello world!";
```

### Output

```php
<?php
/* inline comment */
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
