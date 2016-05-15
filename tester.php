<style type="text/css">

.vertical-centered-text {
  display: table;
}
  .vertical-centered-text > * {
    display: table-cell;
    vertical-align: middle;
  }

/* just for the demo */
html,body {height: 100%;}
body {
  font-family: 'Roboto', 'sans-serif';
  background-color: #1abc9c;
  color: white;
  text-align: center;
}
h1,h2,p {
  font-weight: 300;
  font-size: 2em;
  text-shadow: #16a085 1px 1px 1px;
}
p {
  text-transform: uppercase;
  font-size: 1em;
}
#div {
  margin: 5% auto;
  width: 100%;
  height: 200px;
  border: 2px solid #16a085;
  border-radius: 6px;
  text-align: center;
}
#div2 {
  width: 100px;
  height: 100px;
  border: 2px solid #16a085;
  border-radius: 6px;
  text-align: center;
}
</style>

<h1>Remember you2 hated &lt;table&gt;'s?</h1>
<!--<div id="div"> -->
<div id="div" class="vertical-centered-text">
    <div id="div2">
  <h2>They're still useful to vertical-align text</h2>
</div>
    <div id="div2">
  They're still useful to vertical-align textasada</h2
</div>
    </div>
</div>
<div id="div" class="vertical-centered-text">
  <h2>They're still useful to vertical-align text</h2>
</div>

<p>Support: IE8+</p>
