Tattoo Template
===

Tattoo is a simple hyper text programming language that renders into HTML.

[![Build Status](https://travis-ci.org/mario-deluna/Tattoo.svg)](https://travis-ci.org/mario-deluna/Tattoo)

---

**The language isn't done yet. It's just a concept. But I will do my best to create first prototype in the next few months.**

## Syntax

### simple tag

```
h1 #main-title => "Say hello to Tattoo"
```

HTML:

```html
<h1 id="main-title">Say hello to Tattoo</h1>
```

### tag with scope

```
[form #login-form, action="/login/"]
{
	span .info => "Please provide your login information."
}
```

HTML:

```html
<form id="login-form" action="/login/">
	<span class="info">Please provide you login information.</span>
</form>
```

### modifying scope data

```
[a .ajax-trigger, href: "/notes/save/"]
{
	@this.data: { 
		noteId: 123, 
		userId: 42, 
		revision: 1 
	};
	
	@this.text = "Save your Note"
}
```

HTML:

```html
<a class="ajax-trigger" href="/notes/save/" data-noteId="123" data-userId="42" data-revision="1">Save your Note</a>
```

### The are vars

```
@applicationName = "Tattoo Application"

[head] {
	title => 'Welcome | ' + @applicationName
}
[body][footer] {
	span .small => 'Powerd by ' + @applicationName
}
```

HTML:

```html
<head>
	<title>Welcome | Tattoo Application</title>
</head>
<body>
	<footer>
		<span class="small">Powerd by Tattoo Application</span>
	</footer>
</body>
```

### Loops and tree modifications

```
@pages = {
	{ title: 'Home', link: '/home/', isActive: false },
	{ title: 'About', link: '/about/', isActive: true },
	{ title: 'Terms', link: '/terms/', isActive: false }
}

[ul .navigation]
{
	each @page in @pages
	{
		[li][a .navigation-item, href: @page.link]
		{
			span.navigation-item-title => @page.title
		
			if @page.isActive
			{
				@this.parent.class.add('active')
			}
		}
	}
}
```

HTML:

```html
<ul class="navigation">
	<li>
		<a class="navigation-item" href="/home/">
			<span class="navigation-item-title">Home</span>
		</a>
	</li>
	<li class="active">
		<a class="navigation-item" href="/about/">
			<span class="navigation-item-title">About</span>
		</a>
	</li>
	<li>
		<a class="navigation-item" href="/terms/">
			<span class="navigation-item-title">Terms</span>
		</a>
	</li>
</ul>
```

### Extending tags

```
// the '*' tells tattoo to not automatically print the tag
extend input*: @input
{
	[div .form-group]
	{
		@input.id = 'input-' + @input.name
		
		label .form-label, for: @input.id  => @input.placeholder
		
		@input.class.add( 'form-control' )
		
		if !@this.type {
			@this.type = 'text'
		}
		
		render @input
	}
}

[form action: '/login', method: 'post']
{
	[input name: 'username', placeholder: 'your username']
	[input name: 'password', placeholder: 'your password', type: 'password']
}
```

HTML: 

```html
<form action="/login" method="post">
	<div class="form-group">
		<label for="input-username">your username</label>
		<input id="input-username" class="form-control" type="text" name="username" placeholder="your username" />
	</div>
	<div class="form-group">
		<label for="input-password">your password</label>
		<input id="input-password"class="form-control" type="password" name="password" placeholder="your password" />
	</div>
</form>
```

### Views 

```
view page-header
{
	default @title = 'Unknown'
	default @subtitle = ''
	default @underline = true
	
	[div .page-title]
	{
		[h1]
		{
			print @title + ' '
			
			if @subtitle
			{
				small .subtitle => @subtitle
			}
			
			if @underline
			{
				[hr .page-title-underline]{}
			}
		}
	}
}

[page-header title: 'Welcome', subtitle: 'to tattoo']
```

HTML: 

```html
<div class="page-title">
	<h1>Welcome <small>to tattoo</small></h1>
	<hr class="page-title-underline" />
</div>
```
