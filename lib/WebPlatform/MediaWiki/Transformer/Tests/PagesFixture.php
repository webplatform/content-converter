<?php

namespace WebPlatform\MediaWiki\Transformer\Tests;

class PagesFixture {

  // List namespaces
  public static $NAMESPACE_PREFIXES = array("10"=>"Template:","102"=>"Property:","15"=>"Category:","3000"=>"WPD:","3020"=>"Meta:");

  protected $data = null;

  public function __construct() {
    if($this->data === null) {
      $loop = (array)$this->getXml();
      foreach($loop as $entry) {
        $this->data[] = (array)$entry;
      }
    }

    return $this;
  }

  public function getOne() {
    return $this->data[1][0];
  }

  public function getXml() {
    $xmlString = <<<'MWXML'
<mediawiki xmlns="http://www.mediawiki.org/xml/export-0.10/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.mediawiki.org/xml/export-0.10/ http://www.mediawiki.org/xml/export-0.10.xsd" version="0.10" xml:lang="en">
  <page>
    <title>css/properties/border-radius</title>
    <ns>0</ns>
    <id>44</id>
    <revision>
      <id>69319</id>
      <parentid>69053</parentid>
      <timestamp>2014-09-08T19:05:22Z</timestamp>
      <contributor>
        <username>Renoirb</username>
        <id>10080</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="7864">{{Page_Title}}
{{Flags
|State=Ready to Use
|Editorial notes=
|Checked_Out=No
}}
{{Standardization_Status|W3C Candidate Recommendation}}
{{API_Name}}
{{Summary_Section|The border-radius CSS property allows authors to round the corners of an element. The rounding can be different per-corner, and it could have different horizontal and vertical radii, to produce elliptical curves.}}
{{CSS Property
|Initial value=0
|Applies to=All elements, except the table element when border-collapse is collapse
|Inherited=No
|Media=visual
|Computed value=As specified by individual properties
|Animatable=Yes
|CSS object model property=borderRadius
|CSS percentages=Refer to the corresponding dimension (width or height) of the border box.
|Values={{CSS Property Value
|Data Type=length
|Description=Denotes the size of the circle radius or the horizontal and vertical radii, for elliptical curves. It can be expressed in any unit allowed in [[css/data_types/length|CSS &lt;length&gt; data types]]. em units are useful for controls that scale proportionally with the font-size. Viewport-relative units (vw, vh, vmin, vmax) can be useful for controls that scale with the viewport size. Negative values are invalid. You can specify a single length for all four corners, or two, three or four lengths to specify different lengths for different corners: see the syntax section for more details.
}}{{CSS Property Value
|Data Type=percentage
|Description=Denotes the size of the corner radius, in percentages of the box’s border-box dimensions. Specifically, percentages for the horizontal axis refer to the width of the border-box, percentages for the vertical axis refer to the height of the border-box. Negative values are invalid. You can specify a single percentage for all four corners, or two, three or four percentages to specify different percentages for different corners: see the syntax section for more details.
}}{{CSS Property Value
|Data Type=length / length
|Description=Specifying two sets of length values separated by a forward slash equates to specifying separate lengths for the X and Y radii of the corners, resulting in elliptical corners if the X and Y radii have different lengths. Each set can consist of one, two, three or four values.
}}{{CSS Property Value
|Data Type=percentage / percentage
|Description=Specifying two sets of percentage values separated by a forward slash equates to specifying separate percentages for the X and Y radii of the corners, resulting in elliptical corners if the X and Y radii have percentages resulting in different computed values (depending on the width and height of the element, different percentages might result in the same computed values; see the remarks section for more). Each set can consist of one, two, three or four values.
}}
}}
{{Examples_Section
|Not_required=No
|Examples={{Single Example
|Language=CSS
|Description=One value example
|Code=border-radius: 1em;

/* is equivalent to: */

border-top-left-radius: 1em;
border-top-right-radius: 1em;
border-bottom-right-radius: 1em;
border-bottom-left-radius: 1em;
|LiveURL=http://code.webplatform.org/gist/5495188
}}{{Single Example
|Language=CSS
|Description=Multi value example
|Code=border-radius: 20px 1em 1vw / 0.5em 3em;

/* is equivalent to: */

border-top-left-radius: 20px 0.5em;
border-top-right-radius: 1em 3em;
border-bottom-right-radius: 1vw 0.5em;
border-bottom-left-radius: 1em 3em;
|LiveURL=http://code.webplatform.org/gist/5495188
}}{{Single Example
|Language=CSS
|Description=Create an ellipse, unless the
|Code=border-radius: 50%;

/* Will be a circle if the element’s width is equal to its height */
|LiveURL=http://code.webplatform.org/gist/5495188
}}{{Single Example
|Language=CSS
|Description=Shrinking curves to avoid overlapping
|Code=border-radius: 100% 150%;

/* is equivalent to: */

border-radius: 40% 60%;

/* The values shrink proportionally, all multiplied by the same factor, until there is no overlap */
|LiveURL=http://code.webplatform.org/gist/5495188
}}
}}
{{Notes_Section
|Usage=As with any shorthand property, individual inherited values are not possible, that is &lt;code&gt;border-radius:0 0 inherit inherit&lt;/code&gt;, which would override existing definitions partially. In that case, the individual longhand properties have to be used.

===Syntax===

&lt;code&gt;border-radius&lt;/code&gt; can take between one and four values:

* one value will be applied to all four corners
* two values will be applied to top-left + bottom-right, and top-right + bottom-left, respectively
* three values will be applied to top-left, top-right + bottom-left, and bottom-right, respectively
* four values will be applied to the four corners separately, in the order of top-left, top-right, bottom-right, bottom-left
|Notes====Remarks===

* The '''border-radius''' property is a composite property that specifies up to four '''border-*-radius''' properties. If values are given before and after the slash, the values before the slash set the horizontal radius and the values after the slash set the vertical radius. If there is no slash (&quot;/&quot;), the values set both radii equally. The four values for each radii are given in clockwise order, starting from the top left corner. If less than four values are provided, they are repeated until we get four values, similarly to other CSS properties, such as border-width.
* It’s possible to end up with elliptical corners, even by specifying one radius. This occurs when you are using percentages, since they resolve to a different number for each axis (horizontally they are percentages of the border box width, vertically of the height). For a demonstration, refer to the ellipse example above (example #3)
* Since border-radius rounds the border box of the element, the inner (padding box) corners will have smaller radii (specifically border-radius - border-width), or even no rounding, if the border is thicker than the border-radius value. Another consequence of this is that when there are different border widths on adjacent sides, the curves of the padding box will be elliptical.
* Note that although in the border-radius shorthand, there is a slash (/) to separate horizontal from vertical radii, they are space separated in the longhands.
|Import_Notes=
}}
{{Related_Specifications_Section
|Specifications={{Related Specification
|Name=CSS Backgrounds and Borders Module Level 3: Rounded Corners:
|URL=http://www.w3.org/TR/css3-background/#the-border-radius
|Status=Candidate Recommendation
|Relevant_changes=
}}{{Related Specification
|Name=CSS Backgrounds and Borders Module Level 4: Rounded Corners:
|URL=http://dev.w3.org/csswg/css4-background/#corners
|Status=Editor’s Draft
|Relevant_changes=Added border-corner-shape to let border-radius specify the size of a number of different corner shapes besides rounded corners.
}}
}}
{{See_Also_Section
|Topic_clusters=Border
|Manual_links=
|External_links=
|Manual_sections====Related pages (MSDN)===
*&lt;code&gt;[[css/cssom/CSSStyleDeclaration/CSSStyleDeclaration|CSSStyleDeclaration]]&lt;/code&gt;
*&lt;code&gt;[[css/cssom/currentStyle|currentStyle]]&lt;/code&gt;
*&lt;code&gt;[[css/cssom/style|style]]&lt;/code&gt;
*&lt;code&gt;[[dom/defaultSelected|defaults]]&lt;/code&gt;
*&lt;code&gt;[[css/cssom/runtimeStyle|runtimeStyle]]&lt;/code&gt;
*&lt;code&gt;Reference&lt;/code&gt;
*&lt;code&gt;[[css/properties/border-top-left-radius|border-top-left-radius]]&lt;/code&gt;
*&lt;code&gt;[[css/properties/border-top-right-radius|border-top-right-radius]]&lt;/code&gt;
*&lt;code&gt;[[css/properties/border-bottom-right-radius|border-bottom-right-radius]]&lt;/code&gt;
*&lt;code&gt;[[css/properties/border-bottom-left-radius|border-bottom-left-radius]]&lt;/code&gt;
}}
{{Topics|CSS}}
{{External_Attribution
|Is_CC-BY-SA=No
|Sources=MDN, MSDN
|MDN_link=[https://developer.mozilla.org/en-US/docs/CSS/border-radius Border-radius]
|MSDN_link=[http://msdn.microsoft.com/en-us/library/ie/hh828809%28v=vs.85%29.aspx Windows Internet Explorer API reference]
|HTML5Rocks_link=
}}</text>
      <sha1>jpppht3ye4y0j07t8wcyl7xhswnt9sm</sha1>
    </revision>    <revision>
      <id>69320</id>
      <parentid>69053</parentid>
      <timestamp>2014-09-08T19:15:22Z</timestamp>
      <contributor>
        <username>Renoirb</username>
        <id>10080</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="786">{{Page_Title}}
{{Flags
|State=Ready to Use
|Editorial notes=
|Checked_Out=No
}}
{{Standardization_Status|W3C Candidate Recommendation}}
{{API_Name}}
{{Summary_Section|The border-radius CSS property allows authors to round the corners of an element. The rounding can be different per-corner, and it could have different horizontal and vertical radii, to produce elliptical curves.}}
{{CSS Property
|Initial value=0
|Applies to=All elements, except the table element when border-collapse is collapse
|Inherited=No
|Media=visual
|Computed value=As specified by individual properties
|Animatable=Yes
|CSS object model property=borderRadius
|CSS percentages=Refer to the corresponding dimension (width or height) of the border box.
|Values={{CSS Property Value
|Data Type=length
|Description=Denotes the size of the circle radius or the horizontal and vertical radii, for elliptical curves. It can be expressed in any unit allowed in [[css/data_types/length|CSS &lt;length&gt; data types]]. em units are useful for controls that scale proportionally with the font-size. Viewport-relative units (vw, vh, vmin, vmax) can be useful for controls that scale with the viewport size. Negative values are invalid. You can specify a single length for all four corners, or two, three or four lengths to specify different lengths for different corners: see the syntax section for more details.
}}{{CSS Property Value
|Data Type=percentage
|Description=Denotes the size of the corner radius, in percentages of the box’s border-box dimensions. Specifically, percentages for the horizontal axis refer to the width of the border-box, percentages for the vertical axis refer to the height of the border-box. Negative values are invalid. You can specify a single percentage for all four corners, or two, three or four percentages to specify different percentages for different corners: see the syntax section for more details.
}}{{CSS Property Value
|Data Type=length / length
|Description=Specifying two sets of length values separated by a forward slash equates to specifying separate lengths for the X and Y radii of the corners, resulting in elliptical corners if the X and Y radii have different lengths. Each set can consist of one, two, three or four values.
}}{{CSS Property Value
|Data Type=percentage / percentage
|Description=Specifying two sets of percentage values separated by a forward slash equates to specifying separate percentages for the X and Y radii of the corners, resulting in elliptical corners if the X and Y radii have percentages resulting in different computed values (depending on the width and height of the element, different percentages might result in the same computed values; see the remarks section for more). Each set can consist of one, two, three or four values.
}}
}}</text>
      <sha1>foo</sha1>
    </revision>
  </page>
  <page>
    <title>css/functions/blur</title>
    <ns>0</ns>
    <id>7073</id>
    <revision>
      <id>59933</id>
      <parentid>40676</parentid>
      <timestamp>2014-07-01T18:39:05Z</timestamp>
      <contributor>
        <username>Brianjhong</username>
        <id>32584</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="4047">{{Page_Title|blur()}}
{{Flags
|State=Ready to Use
|Checked_Out=No
}}
{{Standardization_Status|W3C Editor's Draft}}
{{API_Name}}
{{Summary_Section|Blurs an element, for use by the
[[css/properties/filter|'''filter''']] property.  Accepts a distance
measurement within which pixels are randomly scattered. A value of 0
leaves the image as is.
}}
{{CSS_Function
|Content=This CSS property value is reflected in the following image:

 filter: blur(10px);

[[Image:f21-peppers2.jpg|300px]]&amp;nbsp;[[Image:f22-peppers2blur.jpg|300px]]

Note that pixels blur around the contours of image transparencies,
possibly affecting the ability of background content to show through:

[[Image:music_blur.png]]
}}
{{Examples_Section
|Not_required=No
|Examples={{Single Example
|Language=HTML
|Description=The following example shows the difference between two images, where one has a blur of 10px: [[Image:filter_blur.png|400px]]
|Code=&amp;lt;!DOCTYPE html&amp;gt;
&amp;lt;html&amp;gt;
  &amp;lt;head&amp;gt;
    &amp;lt;title&amp;gt;Blur example&amp;lt;/title&amp;gt;
    &amp;lt;style&amp;gt;
      .foo {
        float: left;
      }

      .bar {
        -webkit-filter: blur(10px);
      }
   &amp;lt;/style&amp;gt;
  &amp;lt;/head&amp;gt;
  &amp;lt;body&amp;gt;
    &amp;lt;img src=&amp;quot;http://www.webplatform.org/logo/wplogo_transparent_xlg.png&amp;quot; class=&amp;quot;foo&amp;quot; /&amp;gt;
    &amp;lt;img src=&amp;quot;http://www.webplatform.org/logo/wplogo_transparent_xlg.png&amp;quot; class=&amp;quot;foo bar&amp;quot; /&amp;gt;
  &amp;lt;/body&amp;gt;
&amp;lt;/html&amp;gt;
|LiveURL=http://codepen.io/pverbeek/pen/yiKBv
}}
}}
{{Notes_Section
|Notes=The CSS filter corresponds to this SVG filter definition, based on a
variable ''radius'' passed to the function:

&lt;syntaxhighlight lang=&quot;xml&quot;&gt;
&lt;filter id=&quot;blur&quot;&gt;
  &lt;feGaussianBlur stdDeviation=&quot;[radius radius]&quot;&gt;
&lt;/filter&gt;
&lt;/syntaxhighlight&gt;
}}
{{Related_Specifications_Section
|Specifications={{Related Specification
|Name=Filter Effects 1.0
|URL=https://dvcs.w3.org/hg/FXTF/raw-file/tip/filters/index.html#
|Status=Editor's Draft
}}{{Related Specification
|Name=Filter Effects 1.0
|URL=http://www.w3.org/TR/filter-effects/
|Status=Working Draft
}}
}}
{{Compatibility_Section
|Not_required=No
|Imported_tables=
|Desktop_rows={{Compatibility Table Desktop Row
|Chrome_supported=Unknown
|Chrome_version=
|Chrome_prefixed_supported=Yes
|Chrome_prefixed_version=21.0
|Firefox_supported=No
|Firefox_version=
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=No
|Internet_explorer_version=
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=No
|Opera_version=
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Unknown
|Safari_version=
|Safari_prefixed_supported=Yes
|Safari_prefixed_version=6.0
}}
|Mobile_rows={{Compatibility Table Mobile Row
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=No
|Blackberry_version=
|Blackberry_prefixed_supported=No
|Blackberry_prefixed_version=
|Chrome_mobile_supported=No
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=No
|IE_mobile_version=
|IE_mobile_prefixed_supported=No
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=No
|Opera_mini_version=
|Opera_mini_prefixed_supported=No
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=Yes
|Safari_mobile_prefixed_version=6.0
}}
|Notes_rows=
}}
{{See_Also_Section
|Topic_clusters=Filters
|External_links=* [http://html.adobe.com/webstandards/csscustomfilters/cssfilterlab/ Adobe CSS FilterLab]
* [http://html5-demos.appspot.com/static/css/filters/index.html Interactive demonstration]
}}
{{Topics|CSS, Graphics, SVG}}
{{External_Attribution
|Is_CC-BY-SA=No
|MDN_link=
|MSDN_link=
|HTML5Rocks_link=
}}</text>
      <sha1>8y4bs6tu613m692o2cxkhn07pvdt3a7</sha1>
    </revision>
  </page>
  <page>
    <title>dom/EventTarget/addEventListener</title>
    <ns>0</ns>
    <id>3138</id>
    <revision>
      <id>68473</id>
      <parentid>46134</parentid>
      <timestamp>2014-08-20T17:41:27Z</timestamp>
      <contributor>
        <username>Dgash</username>
        <id>50</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="4467">{{Page_Title}}
{{Flags
|State=Ready to Use
|Checked_Out=No
|High-level issues=Needs Topics, Missing Relevant Sections, Data Not Semantic, Unreviewed Import
|Content=Incomplete, Not Neutral, Cleanup, Compatibility Incomplete, Examples Best Practices
}}
{{Standardization_Status|W3C Recommendation}}
{{API_Name}}
{{Summary_Section|Registers an event handler for the specified event type.}}
{{API_Object_Method
|Parameters={{Method Parameter
|Index=0
|Name=type
|Data type=String
|Description=The type of event [[dom/Event/type|'''type''']] to register.
|Optional=No
}}{{Method Parameter
|Index=1
|Name=handler
|Data type=function
|Description=A '''function''' that is called when the event is fired.
|Optional=No
}}{{Method Parameter
|Index=2
|Name=useCapture
|Data type=Boolean
|Description=A '''Boolean''' value that specifies the event phase to add the event handler for.

While this parameter is officially optional, it may only be omitted in modern browsers.
|Optional=Yes
}}
|Method_applies_to=dom/EventTarget
|Example_object_name=target
|Javascript_data_type=void
}}
{{Examples_Section
|Not_required=No
|Examples={{Single Example
|Language=JavaScript
|Description=This example listens to any click events on the document or its descendants.
|Code=document.addEventListener(
  &quot;click&quot;,
  function (e) {
    console.log(&quot;A &quot; + e.type + &quot; event was fired.&quot;);
  },
  false);
}}
}}
{{Notes_Section
|Notes=#Events are handled in two phases: capturing and bubbling. During the capturing phase, events are dispatched to parent objects before they are dispatched to event targets that are lower in the object hierarchy. During the bubbling phase, events are dispatched to target elements first and then to parent elements. You can register event handlers for either event phase. For more information, see [[dom/Event/eventPhase|'''eventPhase''']].
#Some events, such as [[dom/HTMLElement/focus|'''onfocus''']], do not bubble. However, you can capture all events. You cannot capture events by elements that are not parents of the target element.
#If you register multiple identical event handlers on the same event target, the duplicate event handlers are discarded.
}}
{{Related_Specifications_Section
|Specifications={{Related Specification
|Name=DOM Level 3 Events
|URL=http://www.w3.org/TR/DOM-Level-3-Events/
|Status=Working Draft
|Relevant_changes=Section 4.3
}}
}}
{{Compatibility_Section
|Not_required=No
|Imported_tables=
|Desktop_rows={{Compatibility Table Desktop Row
|Chrome_supported=Yes
|Chrome_version=1
|Chrome_prefixed_supported=Unknown
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=1
|Firefox_prefixed_supported=Unknown
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=9
|Internet_explorer_prefixed_supported=Unknown
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_prefixed_supported=Unknown
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=1
|Safari_prefixed_supported=Unknown
|Safari_prefixed_version=
}}
|Mobile_rows={{Compatibility Table Mobile Row
|Android_supported=Yes
|Android_version=1
|Android_prefixed_supported=Unknown
|Android_prefixed_version=
|Blackberry_supported=Yes
|Blackberry_version=1
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=16
|Chrome_mobile_prefixed_supported=Unknown
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=1
|Firefox_mobile_prefixed_supported=Unknown
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Yes
|IE_mobile_version=9
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Yes
|Opera_mobile_version=1
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=1
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}
|Notes_rows={{Compatibility Notes Row
|Browser=Internet Explorer
|Version=8 and earlier
|Note=Use a legacy proprietary model of '''attachEvent''' and '''detachEvent''' instead.
}}
}}
{{See_Also_Section}}
{{Topics|DOM, DOMEvents}}
{{External_Attribution
|Is_CC-BY-SA=No
|Sources=MSDN
|MDN_link=
|MSDN_link=[http://msdn.microsoft.com/en-us/library/ie/hh828809%28v=vs.85%29.aspx Windows Internet Explorer API reference]
|HTML5Rocks_link=
}}</text>
      <sha1>2q4w9k2zrrdbrscx5u54a34utmjib0k</sha1>
    </revision>
  </page>
  <page>
    <title>ja/concepts/programming/programming basics</title>
    <ns>0</ns>
    <id>6719</id>
    <revision>
      <id>31102</id>
      <parentid>27582</parentid>
      <timestamp>2013-04-16T00:34:49Z</timestamp>
      <contributor>
        <username>Tshimizu3</username>
        <id>12267</id>
      </contributor>
      <minor/>
      <comment>Tshimizu3 moved page [[concepts/programming/programming basics/lang:ja]] to [[ja/concepts/programming/programming basics]]</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="33155">{{Page_Title|プログラミングの基礎}}
{{Flags}}
{{Summary_Section|※ 本記事はまだ試験的に作成しているものである点にご注意願います。

本記事では、JavaScriptを例として、プログラミングの基礎的な原則について述べます。
}}
{{Guide
|Content=== はじめに ==
&lt;!-- サンプルコードはリンク先の実行用サンプルコードとの矛盾を防ぐために翻訳しないまま残している箇所がありますので、ご注意下さい。 --&gt;
経験を積んだプログラマは、遅かれ早かれ、全く技術に詳しくない人々からは、まるで黒魔術でも扱っているかのごとく見られるようになっていくものです。逆の立場から見れば、技術に詳しくない人にとって、もし力を貸してくれている人がいたとしても、何をどうしているのかが伝わらないままであれば、そのうちついて行けなくなってしまいます。[http://www.w3.org/wiki/Web_Standards_Curriculum Web Standards Curriculum]は、プログラミングとは何かを簡単な言葉で説明しており、経験を積んだプログラマにも技術に詳しくない人にもどちらにもわかりやすい内容となっています。

JavaScriptプログラミングの仕方を学ぶ前には必須となる全般的なプログラミングの原則を基礎として固めておくこともまた、初心者のWeb開発者にとっては大変有益となります。一見退屈と思えるかもしれませんが、ご安心下さい。初めのうちに基礎的な原則を踏まえておけば、(ここは大きな声で)後々きっと強固で力強く、創造的な力として、あなたの身になることでしょう。プログラミングの基礎は、特定のプログラミング言語(もちろん、ここではJavaScript)を使ってみる前に習得しておくことが重要なのです。

== まずは触ってみよう ==

プログラミングの基礎を学ぶ上での第一歩は、試しにコマンドを入力して実行、その結果として何が出力されるかを見ることです。プログラミングとは数学と言語の組み合わせのように成り立っており、すなわち、コンピュータに解かせたい計算を正しい文法で順番通りに記述し、コンピュータに渡す作業であると言えます。プログラミングにおいて文法(grammar)とは、何をどういう並びで記述しなければならないといった構文(syntax)を定義するものであり、プログラミング言語によって大幅に異なっています。

例として、次のような2つの簡単なコードを示します。これらは全く同じように動作しますが、前者はJavaScript、後者はPHPで書かれています。

&lt;source lang=&quot;javascript&quot;&gt;
var fahrenheit = prompt('Enter temperature in Fahrenheit', 0);
var celsius = (fahrenheit - 32) * 5 / 9;
alert(celsius);
&lt;/source&gt;

&lt;source lang=&quot;php&quot;&gt;
$fahrenheit = $_GET['fahrenheit'];
$celsius = ($fahrenheit - 32) * 5 / 9;
echo $celsius;
&lt;/source&gt;

それでは、JavaScriptによる[http://dev.opera.com/articles/view/programming-the-real-basics/fahrenheit.html 華氏(℉)から摂氏(℃)への変換サンプル]を試しに動かしてみましょう。

これらのプログラミング言語がコンピュータに解釈されると、何らかの動作や結果が生じます。JavaScriptといったプログラミング言語はWebブラウザが解釈することができます。すなわち、ブラウザに「何かをさせる」には、JavaScriptでその動作をHTML文書の中に記述して、ブラウザで開けばよいのです。一方、他のプログラミング言語では、実行可能にするために一度変換(コンパイル)するといった作業が必要となります。コンピュータは深掘りすると0と1の2つを理解するだけで動作していることになりますが、様々な動作を実現するために多様なレベルの言語が存在しているのです。

== 変数 ==

プログラミングについて理解を進める第一歩は、数学の使い方に立ち返ることです。恐らく学校で学んだことを思い出してみると、次のような式を書くことから数学が始まったのではないでしょうか。

&lt;pre&gt;3 + 5 = 8&lt;/pre&gt;

続いて、例えば次のように未知の値をxとして計算することを勉強し始めることでしょう。

&lt;pre&gt;3 + x = 8&lt;/pre&gt;

この式において、xの値は次のように移項して計算することができるでしょう。

&lt;pre&gt;x = 8 - 3
-&amp;gt; x = 5&lt;/pre&gt;

そして、さらに柔軟に、2個以上の変数を扱うことも可能になっていきます。

&lt;pre&gt;x + y = 8&lt;/pre&gt;

このとき、上の式においてxとyの値を変えていくことができて、

&lt;pre&gt;x = 4
y = 4&lt;/pre&gt;

としても、

&lt;pre&gt;x = 3
y = 5&lt;/pre&gt;

としても、上の等式は成立しているわけです。

同じようにして、プログラミング言語は動作します− プログラミングにおいて、変数は、その都度変化する値を格納するコンテナの役割を果たすのです。変数はあらゆる種類の値、そして、計算結果を保持することができます。変数には名前が与えられ、等号(=)で区切ってその値を指定します。変数名はどのような文字や単語を含むことが可能ですが、利用できるプログラミング言語によって他の機能のために予約されたいくつかの単語があることによる制約があることを覚えておいて下さい。

簡単のため、本記事ではJavaScriptを例としてプログラミング言語について学んでいきます(そもそも本記事自体がJavaScriptプログラミングの記事のうちの一章であるわけですが)。次の例では2つの変数を定義し、その和を計算して、その結果を3つめの変数として定義しています。

注: &lt;code&gt;&amp;lt;script&amp;gt;&lt;/code&gt;タグはブラウザに対してスクリプト言語として実行するよう知らせるために用います。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var x = 5,
    y = 6,
    result = x + y;
&lt;/script&gt;
&lt;/source&gt;

各命令がセミコロン(;)で終わるように書かれたこれらのスクリプトは、ブラウザのJavaScriptインタープリタによって逐次実行されます。セミコロンはインタープリタに対して命令の終わりであることを知らせるために書かれるもので、これは人間が扱う言語において句読点や感嘆符(!)で文章を締めくくるのと同様のものだと言えます。

&lt;!-- 原文では英語を例にしていますが、ここでは日本語に置き換えています。 --&gt;
これらのスクリプトを日本語で表現すると、このような感じになることでしょう:

* ここに記述するものは、HTMLではない他の何かです:
* xという変数を新たに定義し(&lt;code&gt;var&lt;/code&gt;宣言によって表されます)、その値として5を割り当てて、命令を終了します。
* yという変数を新たに定義し、その値として6を割り当てて、命令を終了します。
* resultという変数を新たに定義して、xとyを加算したものをその値として割り当てて、命令を終了し、宣言全体を終了します。(ここで、インタープリタはx、yの値を確認し、その値を加算して生じる結果、すなわち11を得るという演算処理を行います。)
* HTMLとは異なる何らかの言語はここまでであり、HTMLに戻って引き続き解釈を続けます。

2つの間に演算子を追加することで、あらゆる計算を実行することが可能です。古典的なものとして、加算するのにプラス(+)記号、減算するのにマイナス(-)記号があります。ここで、積算(かけ算)ではアスタリスク(*)、除算(割り算)ではスラッシュ(/)を用いる必要があります。記述可能ないくつかの計算例を次に示します。二重スラッシュ(//)で始まるテキストはJavaScriptではコメントとして扱われることにご注意願います。JavaScriptインタープリタではそのようなコメント行を読み込んでも、同じ行内であればそれ以後は実行の対象から除外されます。すなわち、ブラウザに解釈させずに、人間に対して何かのコメントを示したいときにはこのようなコメント行を用います。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var x = 5,
    y = 6,
    z = 20,
    multiply = x * y * z;

// multiplyには600が代入される
var divide = x / y;
// divideには0.8333333333333334が代入される
var addAndDivide = (x + z) / y;
// addAndDivide = 4.166666666666667
var half = (y + z) / 2;
// halfには13が代入される
&lt;/script&gt;
&lt;/source&gt;

このように、計算する際に、変数を組み合わせて使ったり他の変数と同じ値にしたり、変数を固定値として用いたりすることもできます。また、本来期待される演算順に合わせるために括弧()でグループ化することも可能です。(実際の計算では、まず括弧が優先され、その後、積算と除算、加算と減算、そして数学の授業で習うとおりの計算の仕方、の順に従って実行されます。)

=== 変数の型 ===

ところで、電卓でできることをそのままなぞるだけでは、退屈になってくるのではないでしょうか。(もっとも、電卓で5318008と入力して逆さまにすると、(英語圏の人であれば)クスクスと笑ってしまいとは思いますが。)コンピュータはより洗練されたものであり、さらに複雑な変数を扱うことができるのです。そこで本節では変数の「型」について述べます。変数には数値以外にも様々な型があり、プログラミング言語によって異なっています。一般的な型としては次のようなものがあります。

* 小数型(Float): &lt;code&gt;1.21323&lt;/code&gt;, &lt;code&gt;4&lt;/code&gt;, &lt;code&gt;100004&lt;/code&gt; もしくは &lt;code&gt;0.123&lt;/code&gt;のような数値
* 整数型(Integer): &lt;code&gt;1&lt;/code&gt;, &lt;code&gt;12&lt;/code&gt;, &lt;code&gt;33&lt;/code&gt;, &lt;code&gt;140&lt;/code&gt;のような自然数であって、&lt;code&gt;1.233&lt;/code&gt;のようなものではないもの
* 文字列型(String): &quot;&lt;code&gt;boat&lt;/code&gt;&quot;, &quot;&lt;code&gt;象&lt;/code&gt;&quot; あるいは &quot;&lt;code&gt;おお、あなたは背が高いね!&lt;/code&gt;&quot;のような一連の文字列
* ブール型(Boolean): &lt;code&gt;true&lt;/code&gt; または &lt;code&gt;false&lt;/code&gt; のどちらかの値を取り、それ以外の値を取らないもの
* 配列(Array): &lt;code&gt;1,2,3,4,'今、退屈だよ'&lt;/code&gt;のように、複数の値を一つの集合としてまとめたもの
* オブジェクト(Object): オブジェクトを表すもの。ここで、オブジェクトとは現実世界にある対象物を、プロパティとメソッドを定義することによってモデル化して扱おうとするものです。例えば、猫を、4本の脚と一つの尻尾を持ち、茶色であるcatというオブジェクトとして定義することができるでしょう。また、&lt;code&gt;purr()&lt;/code&gt;というメソッドを定義することによって、ゴロゴロと鳴くという動作をオブジェクトcatに定義したり、さらには&lt;code&gt;getCheeseBurger()&lt;/code&gt;というメソッドによってチーズバーガーを欲しがる動作を定義することもできます。さらに、これらのオブジェクト定義を再利用して、色が灰色という以外は同様のプロパティを持つ猫のオブジェクトを定義することもできるのです。

JavaScriptは「型の扱いが緩やかな」プログラミング言語であり、変数に格納されているデータがどのような型であるかを明示的に宣言する必要が無いという特徴があります。変数を宣言するには&lt;code&gt;var&lt;/code&gt;というキーワードを先頭に記述すればよく、どのような文脈や引用でデータの型を使おうとも、ブラウザは正しく動作するようになっています。

==== 小数と整数 ====

ここでは不思議なことや特殊なことは何もないことでしょう。変数には数値であればどのような値でも代入できます。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var fahrenheit = 123,
    celsius = (fahrenheit - 32) * 5/9,
    clue = 0.123123;
&lt;/script&gt;
&lt;/source&gt;

小数と整数はどのような数値演算でも計算可能です。

==== ブール型(boolean) ====

ブール型(boolean)の値は、「イエスかノーか」という単純な定義になっています。具体的には、&lt;code&gt;true&lt;/code&gt;か&lt;code&gt;false&lt;/code&gt;のどちらかのキーワードが値として代入されます。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var doorClosed = true,
    catCanLeave = false;
&lt;/script&gt;
&lt;/source&gt;

==== 文字列 ====

文字列は、一つないし複数の行で構成され、各行がどんな種類の文字でも含むことができます。JavaScriptでは、シングルクオート('')もしくはダブルクオート(&quot;&quot;)で囲むことで文字列を定義できます。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var surname = 'Heilmann',
    name = &quot;Christian&quot;,
    age = '33',
    hair = 'Flickr famous';
&lt;/script&gt;
&lt;/source&gt;

これらの文字列は、+演算子を用いて結合することができますが、減算の要領で文字列からその一部を抜き出すことはできません。文字列を書き換えるには、使っているプログラミング言語で用意されている関数を用いる必要があります。一方、シンプルな文字列の結合は次のような簡単な形で表せます。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var surname = 'Heilmann',
    name = 'Christian',
    age = '33',
    hair = 'Flickr famous',
    message = 'Hi, I am ' + name + ' ' + surname + '. ';

message += 'I am ' + age + 'years old and my hair is ' + hair;
alert(message);
&lt;/script&gt;
&lt;/source&gt;

それでは、[http://dev.opera.com/articles/view/programming-the-real-basics/flickrfamous.html 文字列結合のデモ]を試しに動かしてみましょう。

+=演算子は、&quot;message = message +&quot;を短縮して書いたものです。上記の例の場合は“Hi, I am Christian Heilmann. I am 33 years old and [http://flickr.com/photos/tags/thehairofchristianheilmann/ my hair is Flickr famous]”という結果となります。

ここで見落とせない点は、結合するのか、値を足すのか、ということです。もし2つの値を足すのであれば、文字列ではなく数値であることを確かめる必要があります。例えば、[http://dev.opera.com/articles/view/programming-the-real-basics/concatvsadd.html 結合するのか加算なのかのデモ]では、異なる2つの結果が出力されます。“5”+“3”の結果は53であって8にはならないのです! 文字列から数値に変換する最も簡単な方法として、先ほどのデモ(のソースコード)のように、変数の前に&quot;+&quot;を記述する方法があります(訳注: ここでは &lt;code&gt;y = +y;&lt;/code&gt; のようにしています)。

多くのプログラミング言語では、文字列を囲む際にシングルクオートとダブルクオートのどちらが使われているかは、組み合わせて使われない限りは区別されません。このため、文字列の終わりがどこにあるかでJavaScriptインタプリタに混乱を引き起こさないようにするためには、文字列を囲むのに使われていないクオート記号の前にバックスラッシュ(\)を置く必要があります。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
// この例では、'の後に記述されているものが何であるかを、
// インタープリタが解釈できなくなり、エラーとなります。
// 文字列に代入されるのは、'Isn'となってしまいます。
var stringWithError = 'Isn't it hard to get things right?';
// 次のように記述すれば、エラーは発生しません。
var stringWithoutError = 'Isn\'t it hard to get things right?';
&lt;/script&gt;
&lt;/source&gt;

==== 配列 ====

配列は大変強力な構造を持っています。一つに配列には複数の値を代入することが可能で、それぞれが変数もしくは値を持ちます。次に例を示します。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var pets = new Array('Boomer','Polly','Mr.Frisky');
&lt;/script&gt;
&lt;/source&gt;

それぞれの値には、配列内で付与されたインデックス値である、'''配列の'''カウンタを用いてアクセスすることが可能となっており、本の章番号を見ていくような感覚で利用することができます。具体的には、&lt;code&gt;配列名[インデックス値]&lt;/code&gt;のような構文となります。上の例では、&lt;code&gt;pets[1]&lt;/code&gt;の値は&quot;Polly&quot;となります。でもちょっと待って下さい。Pollyを表すのは、'''2番目に指定された値なのだから'''、&lt;code&gt;pets[2]&lt;/code&gt;であるべきでは? ...答えは'''ノー'''なのです − コンピュータは1からではなく0から数え始めるので、カウンタは2とはならない、というわけです。このことはよく混乱や勘違いを引き起こしたりします。

配列が自動的に生成する特殊な情報として、配列の要素数を表す&lt;code&gt;length&lt;/code&gt;があります。上の例では、&lt;code&gt;pets.length&lt;/code&gt;の値を確認すると、実際に格納されている要素の数である3となるでしょう。

配列は、何か共通の性質のあるものをまとめて扱うのに大いに役に立つものであり、どのプログラミング言語でも、配列を操作する手軽な関数 − ソート、フィルタ、検索、など − を数多く備えています。

==== オブジェクト ====

順番に付与される番号ではなく、より詳細な記述で個々の要素を表してまとめたい場合は、配列ではなく、オブジェクトを生成する必要があります。JavaScriptプログラミングにおいて、オブジェクトは、人々や乗り物、道具といった現実世界にある対象物を表現したりモデル化したりしたものとして構成されます。

オブジェクトは大きくて非常に賢く、そして汎用的なプログラミングの要素であり、その扱い方を詳細に説明するには、本記事で扱える範囲としては大きくなりすぎてしまいます。ここではオブジェクトをいくつかの属性(プロパティ)を持った一つのものとして扱うこととします。まずは例として人を表すpersonというオブジェクトを扱います。このとき、様々なプロパティをドット(.)と合わせてオブジェクト名の後につなげることで定義していくことができます。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var person = new Object();
person.name = 'Chris';
person.surname = 'Heilmann';
person.age = 33;
person.hair = 'Flickr famous';
&lt;/script&gt;
&lt;/source&gt;

プロパティの内容は、ドットに続けて記述するか(&lt;code&gt;person.age&lt;/code&gt;であれば33)、大括弧([])で囲んで記述するか(&lt;code&gt;person['name']&lt;/code&gt;であれば“Chris”)のいずれかの方法で取得することができます。JavaScriptオブジェクトの詳細については、本コースで後ほどより詳細に学びます。

以上が、様々な型の変数に関する概要となります。プログラミングにおけるもう一つの大きな要素として、プログラムの構造とロジックの組み立てがあります。これらについては、さらに2つのプログラミングにおける概念、条件文と繰り返しが必要となってきます。

== 条件文 ==

条件文は、何がどうなっているかをテストするために用いられます。この条件文は、いくつかの使い方において、プログラミングの大変重要な役割を果たします。

何よりもまず、条件文は、どのようなデータが処理中に渡されてもプログラムが動作することを保証するためにもちいられます。もしデータの内容を盲目的に信頼してしまうと、問題が発生してプログラムは誤動作を引き起こすでしょう。もしどうしたいか、および、必要な全ての情報が正しいフォーマットで得られているかどうかをテストすることができるのであれば、プログラムは遙かに安定して動作することでしょう。このように用心して進める手法は、防御的プログラミングと呼ばれています。

もう一つ、条件文は分岐を可能とします。例えば、申し込みフォームを提出するようなプログラムの場合、その動作が枝分かれになるような構成になるのではないでしょうか。このような場合、初歩的な対処として、条件文に合致するか否かによって、異なる分岐先のコードを実行することとなります。

最も簡単な条件文は&lt;code&gt;if&lt;/code&gt;文で、&lt;code&gt;if (条件文) { 処理 … }&lt;/code&gt;のような構文で記述します。ここでは、条件文が成立する場合に、中括弧({})で囲まれた箇所に書かれたコードが実行されます。次の例では、文字列の内容をテストして、その値に応じて別の文字列を代入します。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var country = 'France',
    weather,
    food,
    currency,
    message;

if (country === 'England') {
  weather = 'horrible';
  food = 'filling';
  currency = 'pound sterling';
}

if (country === 'France') {
  weather = 'nice';
  food = 'stunning, but hardly ever vegetarian';
  currency = 'funny, small and colourful';
}

if (country === 'Germany') {
  weather = 'average';
  food = 'wurst thing ever';
  currency = 'funny, small and colourful';
}

message = 'this is ' + country + ', the weather is ' + weather + ', the food is ' + food + ' and the ' + 'currency is ' + currency;
alert(message);
&lt;/script&gt;
&lt;/source&gt;

それでは各自で[http://dev.opera.com/articles/view/programming-the-real-basics/weather.html if文による気候を確認するサンプル]を試してみて下さい。変数countryの値を変えると異なる文章が表示されるのが確認できることでしょう。

条件文を記述する部分には、等号(=)が3個連なっていますが、これは、値だけではなく、データの型も合致しているかどうかをテストするための条件文であることを表すものです。2つの連なる等号(すなわち==)でも、条件文の内容をテストすることはできますが、この場合、&lt;code&gt;if (x == 5)&lt;/code&gt;と宣言したとき、xの値が数値の5であっても文字列&quot;5&quot;であっても、条件文のテストの結果は合致(true)という結果になります。プログラムがどのように挙動するものであるかによって、このことは違う結果をもたらします。

条件文を用いたテストには、他には次のようなものがあります。

* x &amp;gt; 0 - xは0より大きいか?
* x &amp;lt; 0 - xは0より小さいか?
* x &amp;lt;= 4 - xは0以下か?
* x != 'hello' - xは文字列'hello'と違っているか?
* x - 変数xは存在するか(定義済みか)?

条件文は入れ子にすることもできます。次の例では、上の例に対して、変数countryに値が代入されているかどうかを確認する場合の対処について示しています。

&lt;source lang=&quot;javascript&quot;&gt;
&lt;script&gt;
var country = 'Germany',
    weather,
    food,
    currency,
    message;

if (country) {
    if (country == 'England') {
        weather = 'horrible';
        food = 'filling';
        currency = 'pound sterling';
    }

    if (country == 'France') {
        weather = 'nice';
        food = 'stunning, but hardly ever vegetarian';
        currency = 'funny, small and colourful';
    }

    if (country == 'Germany') {
        weather = 'average';
        food = 'wurst thing ever';
        currency = 'funny, small and colourful';
    }

    message = 'this is ' + country + ', the weather is ' + weather + ', the food is ' + food + ' and the ' + 'currency is ' + currency;
    alert(message);
}
&lt;/script&gt;
&lt;/source&gt;

それでは、[http://dev.opera.com/articles/view/programming-the-real-basics/saferweather.html if文で安全に気候を確認するサンプル]を試してみて下さい。変数countryの値を変えると異なる文章が表示されるのが確認できることでしょう。

一方、先に示した(変数countryの内容をテストしない)例では、変数countryに代入された値に対する処理が定義済みであるかどうかにかかわらず、必ず何かしらの文章を表示しようとします。従って、エラーとなるか、もしくは“this is '''undefined''', the weather...”のように表示してしまいます。後者のサンプルではより安全に動作し、もし変数countryが未定義であれば何もしないようになっています。

さらに、複数の条件を&quot;or&quot;や&quot;and&quot;で組み合わせることで、どちらかの条件がtrue、もしくは両方がtrueになっているかどうかをテストすることができます。JavaScriptでは、&quot;or&quot;は&lt;nowiki&gt;||&lt;/nowiki&gt;、&quot;and&quot;は&amp;amp;&amp;amp;で記述することができます。変数xの値が10から20までの間であるかどうかをテストするには、条件文として&lt;code&gt;if(x &amp;gt; 10 &amp;amp;&amp;amp; x &amp;lt; 20)&lt;/code&gt;と記述すればよいのです。また、変数countryの値が&quot;England&quot;か&quot;Germany&quot;のどちらかであるかどうかを確かめるには、条件文として&lt;code&gt;if(country == 'England' &lt;nowiki&gt;||&lt;/nowiki&gt; country == 'Germany')と記述すればよいことになります。

また、&lt;code&gt;else&lt;/code&gt;節を記述すると、最初に記述した条件文が不成立の場合に適用される処理となります。これは、どんな値の場合でも対応しながら、ある特定の値に限って特別な対処を行いたい場合に、非常に有用です。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  var umbrellaMandatory;
  if(country == 'England'){
    umbrellaMandatory = true;
  } else {
    umbrellaMandatory = false;
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

条件文はとても役に立つものですが、使い道は少し限られています。もし何か繰り返して実行したい処理がある場合はどうすればよいでしょうか? 例えば配列の各要素の値に対して段落タグ(&amp;lt;p&amp;gt;〜&amp;lt;/p&amp;gt;)を付け加えたい場合はどうでしょうか? 条件文だけで対処するのであれば、次のように、異なる配列の要素数に対してそれぞれ処理を固定的に記述する羽目に陥ってしまうことでしょう。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  var names = new Array('Chris','Dion','Ben','Brendan');
  var all = names.length;
  if(all == 1){
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
  }
  if(all == 2){
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
    names[1] = '&amp;lt;p&amp;gt;' + names[1] + '&amp;lt;/p&amp;gt;';
  }
  if(all == 3){
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
    names[1] = '&amp;lt;p&amp;gt;' + names[1] + '&amp;lt;/p&amp;gt;';
    names[2] = '&amp;lt;p&amp;gt;' + names[2] + '&amp;lt;/p&amp;gt;';
  }
  if(all == 4){
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
    names[1] = '&amp;lt;p&amp;gt;' + names[1] + '&amp;lt;/p&amp;gt;';
    names[2] = '&amp;lt;p&amp;gt;' + names[2] + '&amp;lt;/p&amp;gt;';
    names[3] = '&amp;lt;p&amp;gt;' + names[3] + '&amp;lt;/p&amp;gt;';
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

これではあまりにも大変な上に柔軟性に欠けてしまいます。プログラミングとは身の回りのことをより便利にするものですし、かといって人間が同じコードを何度も繰り返し書いてしまっては間違いの原因となりかねません。よりよいプログラミングとは機械に対して退屈な作業をしなくて済むようにして、人間にとって本当に成し遂げたいことだけに集中できるようにするものであるはずです。

この例の場合、条件文の代わりに、どのような要素数を持っていても配列の各要素に対して同じ処理を正確に繰り返すことのできる、'''繰り返し'''処理が必要になります。次節では繰り返しを用いて上の例を作り直したものを示します − これらの2つの例を比較すると、繰り返しを用いた方がより手短になることがわかることでしょう。

== 繰り返し ==

繰り返し処理では、一つの変数の値を変化させながら、同じ条件式を繰り返し判定します。最も簡単な繰り返しとして&lt;code&gt;for&lt;/code&gt;文があります。構文は&lt;code&gt;if&lt;/code&gt;文に似ていますが、2つのオプションが付け加わります。

&lt;pre&gt;for(条件文;終了条件文;更新){
  // do it, do it now
}&lt;/pre&gt;

&lt;code&gt;for&lt;/code&gt;を使って繰り返し処理を行うには、通常は繰り返して実行したいコードを中括弧({})で囲みます。ここで、反復して用いる変数を定義して、繰り返し処理の中で値を変化させ続けて、その値が終了条件文に合致するまで繰り返すようにします(合致したとき、インタプリタは繰り返し処理から抜け出して、繰り返し処理の次に記述されたコードから実行するように移ります)。次に例を示します。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot; charset=&quot;utf-8&quot;&amp;gt;
  for(var i = 0;i &amp;lt; 11;i = i + 1){
    // do it, do it now
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

この例では、変数&lt;code&gt;i&lt;/code&gt;の値を最初に0として、11になるまで(すなわち11より小さいうちは)その値を確かめるように処理を定義しています。更新を行う代入式 − &lt;code&gt;i = i + 1&lt;/code&gt; − では、変数&lt;code&gt;i&lt;/code&gt;の値を1増加させて、その上で繰り返し処理を継続して反復していきます。すなわち、これによって11回の繰り返しが行われます。もし&lt;code&gt;i&lt;/code&gt;の値を2増加させるのであれば、繰り返しは6回となります。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  for(var i = 0;i &amp;lt; 11;i = i + 2){
    // do it, do it now
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

前節で示した条件文を用いた例を 繰り返し処理に置き換えると、次のようにより短くよりシンプルなものになります。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  var names = new Array('Chris','Dion','Ben','Brendan');
  var all = names.length;
  for(var i=0;i&amp;lt;all;i=i+1){
    names[i] = '&amp;lt;p&amp;gt;' + names[i] + '&amp;lt;/p&amp;gt;';
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

なお、ここでは変数&lt;code&gt;i&lt;/code&gt;の値は繰り返し処理内で配列のカウンタとして用いています。以上が、繰り返しを用いた効果なのです − 同じことを繰り返し実行できるだけではなく、何回繰り返しが行われたかを把握するためにも利用できるのです。

}}
{{Examples_Section
|Not_required=Yes
|Examples=
}}
{{Notes_Section}}
{{Related_Specifications_Section
|Specifications=
}}
{{See_Also_Section
|Manual_sections==== 練習問題 ===

* 次のコードを実行するとなぜエラーになるのですか? − &lt;code&gt;var x = hello world&lt;/code&gt;
* 次のコードは正しいですか? − &lt;code&gt;var x = 'elephant';var y = &quot;mouse&quot;;&lt;/code&gt;
* 次の条件式はどのような条件をテストするものですか? &lt;code&gt;if(x &amp;gt; 10 &amp;amp;&amp;amp; x &amp;lt; 20 &amp;amp;&amp;amp; x !== 13 &amp;amp;&amp;amp; y &amp;lt; 10)&lt;/code&gt;
* 次の条件式はどのような結果となりますか? &lt;code&gt;if(b &amp;lt; 10 &amp;amp;&amp;amp; b &amp;gt; 20)&lt;/code&gt;?
* 要素として“peter”,“paul”,“mary”,“paddington bear”,“mr.ben”,“zippy” そして “bagpuss” を含む配列に対して繰り返し処理を行い、これらのうち奇数番目の要素それぞれに対して、&quot;odd&quot;というクラス名を付与した段落タグ(&amp;lt;p&amp;gt;〜&amp;lt;/p&amp;gt;)を付与する処理を作成して下さい。 ヒント: 1個おきに要素をテストするには、モジュロ演算(割り算の剰余の計算)を&lt;code&gt;i % 2 == 0&lt;/code&gt;の要領で利用します。
}}
{{Topics|JavaScript}}
{{External_Attribution
|Is_CC-BY-SA=No
|Sources=DevOpera
|MDN_link=
|MSDN_link=
|HTML5Rocks_link=
}}
{{WPDLanguages}}</text>
      <sha1>m9xkydrui614if4x6gq4a7v3dfep5w8</sha1>
    </revision>
  </page>
</mediawiki>
MWXML;

    return simplexml_load_string($xmlString);
  }
}
