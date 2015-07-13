<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests;

/**
 * Tests Fixtures.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class PagesFixture
{
    /** @var SimpleXMLElement obje */
    protected $data = null;

    public function __construct()
    {
        $this->data = $this->getXml();

        return $this;
    }

    public function getOne()
    {
        return $this->data->page[0];
    }

    public function getXml()
    {
        if ($this->data instanceof SimpleXMLElement) {
            return $this->data;
        }
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
        <username>Dgash</username>
        <id>50</id>
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
    </revision>
    <revision>
      <id>69320</id>
      <parentid>69053</parentid>
      <timestamp>2014-09-08T19:15:22Z</timestamp>
      <contributor>
        <username>Shepazu</username>
        <id>2</id>
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
    <title>tutorials/what is css</title>
    <ns>0</ns>
    <id>1709</id>
    <redirect title="tutorials/learning what css is" />
    <revision>
      <id>6048</id>
      <timestamp>2012-10-02T15:39:44Z</timestamp>
      <contributor>
        <username>Cmills</username>
        <id>11</id>
      </contributor>
      <comment>Cmills moved page [[tutorials/what is css]] to [[tutorials/learning what css is]]</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="44">#REDIRECT [[tutorials/learning what css is]]</text>
      <sha1>kga6mkzkwxmaibhcopxb9awb5sgufz3</sha1>
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

ブール型(boolean) の値は、「イエスかノーか」という単純な定義になっています。具体的には、&lt;code&gt;true&lt;/code&gt;か&lt;code&gt;false&lt;/code&gt;のどちらかのキーワードが値として代入されます。

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
  if (country == 'England') {
    umbrellaMandatory = true;
  } else {
    umbrellaMandatory = false;
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

条件文はとても役に立つものですが、使い道は少し限られています。もし何か繰り返して実行したい処理がある場合はどうすればよいでしょうか? 例えば配列の各要素の値に対して段落タグ(&amp;lt;p&amp;gt;〜&amp;lt;/p&amp;gt;)を付け加えたい場合はどうでしょうか? 条件文だけで対処するのであれば、次のように、異なる配列の要素数に対してそれぞれ処理を固定的に記述する羽目に陥ってしまうことでしょう。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  var names = new Array('Chris','Dion','Ben','Brendan');
  var all = names.length;
  if (all == 1) {
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
  }
  if (all == 2) {
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
    names[1] = '&amp;lt;p&amp;gt;' + names[1] + '&amp;lt;/p&amp;gt;';
  }
  if (all == 3) {
    names[0] = '&amp;lt;p&amp;gt;' + names[0] + '&amp;lt;/p&amp;gt;';
    names[1] = '&amp;lt;p&amp;gt;' + names[1] + '&amp;lt;/p&amp;gt;';
    names[2] = '&amp;lt;p&amp;gt;' + names[2] + '&amp;lt;/p&amp;gt;';
  }
  if (all == 4) {
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

&lt;pre&gt;for (条件文;終了条件文;更新) {
  // do it, do it now
}&lt;/pre&gt;

&lt;code&gt;for&lt;/code&gt;を使って繰り返し処理を行うには、通常は繰り返して実行したいコードを中括弧({})で囲みます。ここで、反復して用いる変数を定義して、繰り返し処理の中で値を変化させ続けて、その値が終了条件文に合致するまで繰り返すようにします(合致したとき、インタプリタは繰り返し処理から抜け出して、繰り返し処理の次に記述されたコードから実行するように移ります)。次に例を示します。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot; charset=&quot;utf-8&quot;&amp;gt;
  for (var i = 0;i &amp;lt; 11;i = i + 1) {
    // do it, do it now
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

この例では、変数&lt;code&gt;i&lt;/code&gt;の値を最初に0として、11になるまで(すなわち11より小さいうちは)その値を確かめるように処理を定義しています。更新を行う代入式 − &lt;code&gt;i = i + 1&lt;/code&gt; − では、変数&lt;code&gt;i&lt;/code&gt;の値を1増加させて、その上で繰り返し処理を継続して反復していきます。すなわち、これによって11回の繰り返しが行われます。もし&lt;code&gt;i&lt;/code&gt;の値を2増加させるのであれば、繰り返しは6回となります。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  for (var i = 0;i &amp;lt; 11;i = i + 2) {
    // do it, do it now
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

前節で示した条件文を用いた例を 繰り返し処理に置き換えると、次のようにより短くよりシンプルなものになります。

&lt;pre&gt;&amp;lt;script type=&quot;text/javascript&quot;&amp;gt;
  var names = new Array('Chris','Dion','Ben','Brendan');
  var all = names.length;
  for (var i=0;i&amp;lt;all;i=i+1) {
    names[i] = '&amp;lt;p&amp;gt;' + names[i] + '&amp;lt;/p&amp;gt;';
  }
&amp;lt;/script&amp;gt;&lt;/pre&gt;

なお、ここでは変数&lt;code&gt;i&lt;/code&gt;の値は繰り返し処理内で配列のカウンタとして用いています。以上が、繰り返しを用いた効果なのです − 同じことを繰り返し実行できるだけではなく、何回繰り返しが行われたかを把握するためにも利用できるのです。

}}
{{Examples_Section
|Not_required=Yes
|Examples=
}}
{{Notes_Section
|Usage=    ラミン

hi we should get

Multiline and still valid-looking kanji.

}}
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
  <page>
    <title>WPD:Content List/Topic Pages</title>
    <ns>3000</ns>
    <id>1324</id>
    <redirect title="WPD:Content/Topic Pages" />
    <revision>
      <id>34321</id>
      <parentid>46134</parentid>
      <timestamp>2014-05-20T13:11:27Z</timestamp>
      <contributor>
        <username>Tyriar</username>
        <id>10768</id>
      </contributor>
      <minor/>
      <comment>Fixing double redirect</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="37">#REDIRECT [[WPD:Content/Topic Pages]]</text>
      <sha1>2q4w9k2zrrdf3rscx5u54ba3utmjib0k</sha1>
    </revision>
  </page>
  <page>
    <title>tutorials/html5 form features</title>
    <ns>0</ns>
    <id>739</id>
    <revision>
      <id>101073</id>
      <parentid>70709</parentid>
      <timestamp>2015-03-02T21:55:26Z</timestamp>
      <contributor>
        <username>Awwright</username>
        <id>42430</id>
      </contributor>
      <comment>Fix HTML snippets</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="45367">{{Page_Title|HTML5 form features}}
{{Flags
|State=Ready to Use
|Editorial notes=
|Checked_Out=No
}}
{{Byline
|Name=
|URL=
|Published=
}}
{{Summary_Section|In this tutorial we will take you through the new HTML5 form features.}}
{{Guide
|Content=== Introduction ==

HTML5 includes many new features that make web forms much easier to write, and more powerful and consistent across the Web.
This article gives a brief overview of some of the new form controls and functionalities that have been introduced.

== Why did we need new form features? ==

Let's face it, HTML forms have always been a pain. They are not much fun to mark up and they can be difficult to style &amp;mdash; especially if you want
them to be consistent across browsers and fit in with the overall look and feel of your site. And they can be frustrating for your end users to fill
out, even if you create them with care and consideration to make them as usable and accessible as possible. Creating a good form is more about damage
limitation than pleasurable user experiences.

Back when HTML 4.01 became a stable recommendation, the web was a mostly static place. Yes, there was the odd comment form or guest book script, but
generally web sites were just there for visitors to read. Since then, the web has evolved. For many people, the browser has already become a window
into a world of complex, web-based applications that bring them an almost desktop-like experience.

[[Image:html5formfig1.png|Some complicated non-native form controls, faked with JavaScript]]

''Figure 1: Some complicated non-native form controls, faked with JavaScript.''

To fill the need for the more sophisticated controls required for such applications, developers have been taking advantage of JavaScript libraries
and frameworks such as jQueryUI and YUI. These solutions have certainly matured over the years, but essentially they're a workaround to compensate
for the limited form controls available in HTML. They &quot;fake&quot; the more complex widgets like date pickers and sliders by layering additional
(but not always semantic) markup and lots of JavaScript on top of pages.

HTML5 aims to standardise some of the most common rich form controls, making them render natively in the browser and obviating the need for these
script-heavy workarounds.

== Introducing our example ==

To illustrate some of the new features, this article builds a basic HTML5 forms example. It's not meant to represent a &quot;real&quot; form (as you'd be
hard-pressed to find a situation where you need all the new features in a single form), but it should give you an idea of how the various new
aspects look and behave.

Note: The look and feel of the new form controls and validation messages differs from brower to browser, so styling your forms to look reasonably
consistent across browsers still needs careful consideration.

== New form controls ==

As forms are the main tool for data input in web applications, and as the data we want to collect has become more complex, it has been necessary
to create an input element with more capabilities, to collect the data with more semantics and better definition, and to allow for easier, more
effective validation and error management.

=== &amp;lt;input type=&quot;number&quot;/&amp;gt; ===

The first new input type we'll discuss is &lt;code&gt;type=&quot;number&quot;&lt;/code&gt;:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;number&quot;/&gt;&lt;/syntaxhighlight&gt;

This input type creates a special kind of input field for number entry &amp;mdash; in most supporting browsers this appears as a text entry field with
a &quot;spinner&quot; control, which allows you to increment and decrement its value.

[[Image:html5formfig2.png|A number input type]]

''Figure 2: A &lt;code&gt;number&lt;/code&gt; input type.''

=== &amp;lt;input type=&quot;range&quot;/&amp;gt; ===

Creating a slider control to allow you to choose among a range of values used to be a complicated, semantically dubious proposition,
but with HTML5 it is easy &amp;mdash; you just use the &lt;code&gt;range&lt;/code&gt; input type:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;range&quot;/&gt;&lt;/syntaxhighlight&gt;

[[Image:html5formfig3.png|A range input type]]

''Figure 3: A &lt;code&gt;range&lt;/code&gt; input type.''

Note that, by default, this input does not generally show the currently selected value, or even the range of values it covers. Authors must
provide these through other means; for instance, to display the current value, we could use an &lt;code&gt;&amp;lt;output&amp;gt;&lt;/code&gt; element together
with some JavaScript to update its display whenever the user interacts with the form:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;form oninput=&quot;output.value = weight.value&quot;&gt;
    &lt;input type=&quot;range&quot; id=&quot;weight&quot;/&gt;
    &lt;output id=&quot;output&quot;&gt;&lt;/output&gt;
&lt;/form&gt;&lt;/syntaxhighlight&gt;

=== &amp;lt;input type=&quot;date&quot;/&amp;gt; and other date/time controls ===

HTML5 has a number of different input types for creating complicated date/time pickers, like the kind of you see featured on most
flight/train booking sites. These used to be created using unsemantic kludges, so it is great that we now have standardized, easy ways
to do this. For example:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;date&quot;/&gt;
&lt;input type=&quot;time&quot;/&gt;&lt;/syntaxhighlight&gt;

Respectively, these create a fully functioning date picker, and a text input containing a separator for hours, minutes, and seconds
(depending on the &lt;code&gt;step&lt;/code&gt; attribute specified) that only allows you to input a time value.

[[Image:html5formfig4.png|date and time input types]]

''Figure 4: &lt;code&gt;date&lt;/code&gt; and &lt;code&gt;time&lt;/code&gt; input types.''

But it doesn't end here &amp;mdash; there are a number of other related input types available:

* &lt;code&gt;datetime&lt;/code&gt;: combines the functionality of the two we looked at above, allowing you to choose a date and a time.
* &lt;code&gt;month&lt;/code&gt;: allows you to choose a month, stored internally as a number between 1-12, although different browsers may provide you with more elaborate choosing mechanisms, like a scrolling list of the month names.
* &lt;code&gt;week&lt;/code&gt;: allows you to choose a week, stored internally in the format 2010-W37 (week 37 of the year 2010), and chosen using a similar datepicker to the ones we have seen already.

=== &amp;lt;input type=&quot;color&quot;/&amp;gt; ===

This input type brings up a color picker. Opera's implementation allows the user to pick from a selection of colors, enter hexadecimal values
directly in a text field, or invoke the operating system's native color picker.

[[Image:html5formfig5.png|a color input, and the native color pickers on Windows and OS X]]

''Figure 5: a &lt;code&gt;color&lt;/code&gt; input, and the native color pickers on Windows and OS X.''

=== &lt;input type=&quot;search&quot;/&gt; ===

This input type is arguably nothing more than a differently-styled text input. Browsers are meant to style these inputs the same way as any
OS-specific search functionality. Beyond this purely aesthetic consideration, though, it's still important to note that marking up search fields
explicitly opens up the possibility for browsers, assistive technologies, or automated crawlers to do something clever with these inputs
in the future. For instance, a browser could conceivably offer the user a choice to automatically create a custom search for a specific site.

[[Image:html5formfig6.png|A search input as it appears in Opera on OS X]]

''Figure 6: A &lt;code&gt;search&lt;/code&gt; input as it appears in Opera on OS X.''

=== The &amp;lt;datalist&amp;gt; element and list attribute ===

So far we have been used to using &lt;code&gt;&amp;lt;select&amp;gt;&lt;/code&gt; and &lt;code&gt;&amp;lt;option&amp;gt;&lt;/code&gt; elements to create dropdown lists of options for our
users to choose from. But what if we wanted to create a list that allowed users to choose from a list of suggested options, as well as being able to
type in their own? That used to require a lot of fiddly scripting, but now you can simply use the &lt;code&gt;list&lt;/code&gt; attribute to connect an ordinary
input to a list of options, defined inside a &lt;code&gt;&amp;lt;datalist&amp;gt;&lt;/code&gt; element.

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;text&quot; list=&quot;mydata&quot;/&gt;
&lt;datalist id=&quot;mydata&quot;&gt;
    &lt;option label=&quot;Mr&quot; value=&quot;Mister&quot;/&gt;
    &lt;option label=&quot;Mrs&quot; value=&quot;Mistress&quot;/&gt;
    &lt;option label=&quot;Ms&quot; value=&quot;Miss&quot;/&gt;
&lt;/datalist&gt;&lt;/syntaxhighlight&gt;

[[Image:html5formfig7.png|Creating an input element with preset options using datalist]]

''Figure 7: Creating an input element with suggestions using &lt;code&gt;datalist&lt;/code&gt;.''

=== &amp;lt;input type=&quot;tel&quot;/&amp;gt;, &amp;lt;input type=&quot;email&quot;/&amp;gt; and &amp;lt;input type=&quot;url&quot;/&amp;gt; ===

As their names imply, these new input types relate to telephone numbers, email addresses, and URLs (here including URIs and IRIs). Browsers will render these as normal text inputs,
but explicitly stating what kind of text we're expecting in these fields plays an important role in client-side form validation. Additionally, on
certain mobile devices the browser will switch from its regular text entry on-screen keyboard to the more context-relevant variants. Again, it's
conceivable that in the future browsers will take further advantage of these explicitly marked-up inputs to offer additional functionality, such as
autocompleting email addresses and telephone numbers based on the user's contacts list or address book.

== New attributes ==

In addition to the explicit new input types, HTML5 defines a series of new attributes for form controls that help simplify some common tasks and
further specify the expected values for certain entry fields.

=== placeholder ===

A common usability trick in web forms is to have placeholder content in text entry fields &amp;mdash; for instance, to give more information about the
expected type of information we want the user to enter &amp;mdash; which disappears when a user starts entering a value or when the form control gets
focus. While this used to require some JavaScript (clearing the contents of the form field on focus and resetting it to the default text if the user
left the field without entering anything), we can now simply use the &lt;code&gt;placeholder&lt;/code&gt; attribute:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;text&quot; placeholder=&quot;John Doe&quot;/&gt;&lt;/syntaxhighlight&gt;

[[Image:html5formfig8.png|A text input with placeholder text]]

''Figure 8: A text input with &lt;code&gt;placeholder&lt;/code&gt; text.''

=== autofocus ===

Another common feature that previously had to rely on scripting is having a form field automatically focused when a page is loaded. This can now be
achieved very simply with the &lt;code&gt;autofocus&lt;/code&gt; attribute:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;text&quot; autofocus=&quot;&quot;/&gt;&lt;/syntaxhighlight&gt;

Keep in mind that you shouldn't have more than one &lt;code&gt;autofocus&lt;/code&gt; form control on a single page. You should also use this sort of
functionality with caution, especially in situations where a form represents the main area of interest in a page. A search page is a good example
&amp;mdash; provided that there isn't a lot of content and explanatory text, it makes sense to set the focus automatically to the text input of the
search form.

=== min and max ===

As their names suggest, this pair of attributes allows you to set a lower and upper bound for the values that can be entered into a numerical form
field, like a number, range, time or date input types. Yes, you can even use it to set upper and lower bounds for dates &amp;mdash; for instance, on a
travel booking form you could limit the datepicker to only allow the user to select future dates. For &lt;code&gt;range&lt;/code&gt; inputs, &lt;code&gt;min&lt;/code&gt;
and &lt;code&gt;max&lt;/code&gt; are actually necessary to define what values are returned when the form is submitted. The code is pretty simple and
self-explanatory:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;number&quot; min=&quot;1&quot; max=&quot;10&quot;/&gt;&lt;/syntaxhighlight&gt;

=== step ===

The &lt;code&gt;step&lt;/code&gt; attribute can be used with a numerical input value to dictate how granular the values you can input can be.
For example, you might want users to enter a particular time, but only in 30 minute increments. In this case, we can use the &lt;code&gt;step&lt;/code&gt;
attribute, keeping in mind that for &lt;code&gt;time&lt;/code&gt; inputs the value of the attribute is in seconds:

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;time&quot; step=&quot;1800&quot;/&gt;&lt;/syntaxhighlight&gt;

== New output mechanisms ==

Beyond the new form controls that users can interact with, HTML5 defines a series of new elements specifically meant to display and visualise
information to the user.

=== &amp;lt;output&amp;gt; ===

We already mentioned the &lt;code&gt;&amp;lt;output&amp;gt;&lt;/code&gt; element when talking about the &lt;code&gt;range&lt;/code&gt; input type &amp;mdash; this element serves
as a way to display the result of a calculation or, more generally, to provide an explicitly identified output of a script (rather than simply
pushing some text into in a random &lt;code&gt;span&lt;/code&gt; or &lt;code&gt;div&lt;/code&gt;). To make it even more explicit what particular form controls the
&lt;code&gt;&amp;lt;output&amp;gt;&lt;/code&gt; relates to, we can (in a similar way to &lt;code&gt;&amp;lt;label&amp;gt;&lt;/code&gt;) pass a list of &lt;code&gt;ID&lt;/code&gt;s in the element's
optional &lt;code&gt;for&lt;/code&gt; attribute.

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;range&quot; id=&quot;rangeexample&quot;/&gt;
&lt;output onforminput=&quot;value=rangeexample.value&quot; for=&quot;rangeexample&quot;&gt;&lt;/output&gt;&lt;/syntaxhighlight&gt;

=== &amp;lt;progress&amp;gt; and &amp;lt;meter&amp;gt; ===

These two new elements are very similar, both resulting in a gauge/bar being presented to the user. Their distinction is in their intended purpose.
As the name suggests, &lt;code&gt;progress&lt;/code&gt; is meant to represent a progress bar, to indicate the percentage of completion of a particular task,
while meter is a more generic indicator of a scalar measurement or fractional value.

[[Image:html5formfig9.png|A progress indicator bar]]

''Figure 9: A progress indicator bar.''

== Validation ==

Form validation is very important on both client- and server-side, to help legitimate users avoid and correct mistakes, and to prevent malicious
users from submitting data that could cause damage to the application. As browsers can now get an idea of what types of values are expected from
the various form controls (be it their &lt;code&gt;type&lt;/code&gt;, or any upper/lower bounds set on numerical values, dates and times), they can also offer
native form validation &amp;mdash; another tedious task that, up to now, required authors to write reams of JavaScript or use some ready-made
validation script or library.

Note: For form controls to be validated, they must have a &lt;code&gt;name&lt;/code&gt; attribute, as without it they wouldn't be submitted as part of the
form anyway.

=== required ===

One of the most common aspects of form validation is the enforcement of required fields &amp;mdash; not allowing a form to be submitted until certain
pieces of information have been entered. This can now simply be achieved by adding the &lt;code&gt;required&lt;/code&gt; attribute to an &lt;code&gt;input&lt;/code&gt;,
&lt;code&gt;select&lt;/code&gt; or &lt;code&gt;textarea&lt;/code&gt; element.

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;text&quot; required=&quot;&quot;/&gt;&lt;/syntaxhighlight&gt;

[[Image:html5formfig10.png|Opera's client-side validation in action, showing an error for a required field that was left empty]]

''Figure 10: Opera's client-side validation in action, showing an error for a required field that was left empty.''

=== type and pattern ===

As we've seen, authors can now specify the kinds of entries they expect from their form fields. Rather than simply defining text inputs,
authors can explicitly create inputs for things like numbers, email addresses, and URLs. As part of their client-side validation, browsers can now
check that what the user entered in these more specific fields matches the expected structure. In essence, browsers can evaluate the input values
against a built-in pattern that defines what valid entries in those types of inputs look like, and can warn a user when their entry doesn't meet
the criteria.

[[Image:html5formfig11.png|Opera's error message for invalid email addresses in an email input]]

''Figure 11: Opera's error message for invalid email addresses in an &lt;code&gt;email&lt;/code&gt; input.''

For other text entry fields that nonetheless need to follow a certain structure (for instance, login forms where the usernames can only contain a
specific sequence of lowercase letters and numbers), authors can use the &lt;code&gt;pattern&lt;/code&gt; attribute to specify their own custom regular
expression.

&lt;syntaxhighlight lang=&quot;html5&quot;&gt;&lt;input type=&quot;text&quot; pattern=&quot;[a-z]{3}[0-9]{3}&quot;/&gt;&lt;/syntaxhighlight&gt;

== Browser support ==

On the desktop, [[http://www.opera.com Opera]] currently has the most complete implementation of new input types and native client-side validation,
but support is on the way for all other major browsers as well, so it won't be long before we can take advantage of these new powerful tools in our
projects. But what about older browser versions?

By design, browsers that don't understand the new input types like &lt;code&gt;date&lt;/code&gt; or &lt;code&gt;number&lt;/code&gt; will simply fall back to treating
them as standard text inputs &amp;mdash; not as user-friendly as their advanced HTML5 counterparts, but at the very least they allow for a form to
be filled in.

==Conclusion==
In this article, you've seen the new HTML5 form elements and attributes and learned how to use them. For a more general treatment of
standard HTML forms, please see the previous article [[guides/html_forms_basics|HTML forms basics]].
}}
{{Notes_Section
|Usage=
|Notes=
|Import_Notes=
}}
{{Compatibility_Section
|Not_required=No
|Imported_tables=
|Desktop_rows={{Compatibility Table Desktop Row
|Feature=autofocus
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.6
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.0
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=&lt;datalist&gt;
|Chrome_supported=Yes
|Chrome_version=20.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.5
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=No
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=&lt;meter&gt;
|Chrome_supported=Yes
|Chrome_version=8.0
|Chrome_prefixed_supported=Unknown
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=16.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=No
|Internet_explorer_version=
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=15.0
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.2
|Safari_prefixed_supported=Unknown
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=min, max and step
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=No
|Firefox_version=
|Firefox_prefixed_supported=Unknown
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=10.6
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.0
|Safari_prefixed_supported=Unknown
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=&lt;output&gt;
|Chrome_supported=Yes
|Chrome_version=13.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=6.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10.0
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.2
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.1
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=pattern
|Chrome_supported=Yes
|Chrome_version=10
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=11.01
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=No
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=placeholder
|Chrome_supported=Yes
|Chrome_version=4.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=11.6
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=&lt;progress&gt;
|Chrome_supported=Yes
|Chrome_version=6.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=6.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=10.6
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.2
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=required
|Chrome_supported=Yes
|Chrome_version=6.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.6
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=No
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;color&quot;
|Chrome_supported=Yes
|Chrome_version=20.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=No
|Firefox_version=
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=No
|Internet_explorer_version=
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=11.0
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=No
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;date&quot;
|Chrome_supported=No
|Chrome_version=
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=No
|Firefox_version=
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=No
|Internet_explorer_version=
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.5
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=No
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;email&quot;
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=10.62
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Unknown
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;number&quot;
|Chrome_supported=Yes
|Chrome_version=7.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=No
|Firefox_version=
|Firefox_prefixed_supported=Unknown
|Firefox_prefixed_version=
|Internet_explorer_supported=No
|Internet_explorer_version=
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.5
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=5.0
|Safari_prefixed_supported=Unknown
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;range&quot;
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=23
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=9.5
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=3.1
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;search&quot;
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=11.01
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Yes
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;tel&quot;
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=11.01
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Unknown
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}{{Compatibility Table Desktop Row
|Feature=type=&quot;url&quot;
|Chrome_supported=Yes
|Chrome_version=5.0
|Chrome_prefixed_supported=No
|Chrome_prefixed_version=
|Firefox_supported=Yes
|Firefox_version=4.0
|Firefox_prefixed_supported=No
|Firefox_prefixed_version=
|Internet_explorer_supported=Yes
|Internet_explorer_version=10
|Internet_explorer_prefixed_supported=No
|Internet_explorer_prefixed_version=
|Opera_supported=Yes
|Opera_version=10.62
|Opera_prefixed_supported=No
|Opera_prefixed_version=
|Safari_supported=Unknown
|Safari_version=
|Safari_prefixed_supported=No
|Safari_prefixed_version=
}}
|Mobile_rows={{Compatibility Table Mobile Row
|Feature=autofocus
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=Unknown
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=&lt;datalist&gt;
|Android_supported=Unknown
|Android_version=
|Android_prefixed_supported=Unknown
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=No
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=15.0
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Yes
|Opera_mobile_version=10.0
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Unknown
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=&lt;meter&gt;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=Unknown
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Yes
|Opera_mobile_version=11.0
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Unknown
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=min, max and step
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Unknown
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=Unknown
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=&lt;output&gt;
|Android_supported=Yes
|Android_version=2.1
|Android_prefixed_supported=Unknown
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=4.0
|Firefox_mobile_prefixed_supported=Unknown
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=5
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=pattern
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=placeholder
|Android_supported=Yes
|Android_version=3.2
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=2.1
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=&lt;progress&gt;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=6.0
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Yes
|Opera_mobile_version=11
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=required
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=Unknown
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=Unknown
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;color&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=No
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;date&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=18
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=5.0
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;email&quot;
|Android_supported=Yes
|Android_version=3.1
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=15.0
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=3.1
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;number&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;range&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=No
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=5.0
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;search&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=No
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;tel&quot;
|Android_supported=Yes
|Android_version=3.1
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=15.0
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Unknown
|Opera_mobile_version=
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=Yes
|Safari_mobile_version=3.1
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}{{Compatibility Table Mobile Row
|Feature=type=&quot;url&quot;
|Android_supported=No
|Android_version=
|Android_prefixed_supported=No
|Android_prefixed_version=
|Blackberry_supported=Unknown
|Blackberry_version=
|Blackberry_prefixed_supported=Unknown
|Blackberry_prefixed_version=
|Chrome_mobile_supported=Yes
|Chrome_mobile_version=
|Chrome_mobile_prefixed_supported=No
|Chrome_mobile_prefixed_version=
|Firefox_mobile_supported=Yes
|Firefox_mobile_version=15
|Firefox_mobile_prefixed_supported=No
|Firefox_mobile_prefixed_version=
|IE_mobile_supported=Unknown
|IE_mobile_version=
|IE_mobile_prefixed_supported=Unknown
|IE_mobile_prefixed_version=
|Opera_mobile_supported=Yes
|Opera_mobile_version=12
|Opera_mobile_prefixed_supported=No
|Opera_mobile_prefixed_version=
|Opera_mini_supported=Unknown
|Opera_mini_version=
|Opera_mini_prefixed_supported=Unknown
|Opera_mini_prefixed_version=
|Safari_mobile_supported=No
|Safari_mobile_version=
|Safari_mobile_prefixed_supported=No
|Safari_mobile_prefixed_version=
}}
|Notes_rows=
}}
{{See_Also_Section
|Manual_links=
|External_links=
|Manual_sections==== Exercise Questions ===

* Why is it a good idea to mark up menus as lists?
* When you design a navigation menu, what do you need to plan for in the future?
* What are the benefits of using &lt;code&gt;&amp;lt;select&amp;gt;&lt;/code&gt; elements for menus, and what are the problems?
* What do you define with &lt;code&gt;&amp;lt;area&amp;gt;&lt;/code&gt; elements, and what is the &lt;code&gt;nohref&lt;/code&gt; attribute of an area element for (this is not in here, you'd need to do some online research)
* What are the benefits of skip links?
}}
{{Topics|HTML}}
{{External_Attribution
|Is_CC-BY-SA=No
|MDN_link=
|MSDN_link=
|HTML5Rocks_link=
}}</text>
      <sha1>ncm7t9f1bh3bruk22gt4uhok2h1kjte</sha1>
    </revision>
  </page>
  <page>
    <title>concepts/programming/javascript/overview</title>
    <ns>0</ns>
    <id>786</id>
    <revision>
      <id>58596</id>
      <parentid>12944</parentid>
      <timestamp>2014-06-24T13:02:49Z</timestamp>
      <contributor>
        <username>Paulv</username>
        <id>9756</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="10202">{{Page_Title|Overview}}
{{Flags
|State=Not Ready
|Content=Outdated
|Compatibility=Outdated, Incomplete
}}
{{Byline}}
{{Summary_Section|This chapter introduces JavaScript and discusses some of its fundamental concepts.}}
=What is JavaScript?=

JavaScript is a cross-platform, object-oriented scripting language. JavaScript is a small, lightweight language; it is not useful as a standalone language, but is designed for easy embedding in other products and applications, such as web browsers. Inside a host environment, JavaScript can be connected to the objects of its environment to provide programmatic control over them.

Core JavaScript contains a core set of objects, such as Array, Date, and Math, and a core set of language elements such as operators, control structures, and statements. Core JavaScript can be extended for a variety of purposes by supplementing it with additional objects; for example:

* ''Client-side JavaScript'' extends the core language by supplying objects to control a browser (Navigator or another web browser) and its Document Object Model (DOM). For example, client-side extensions allow an application to place elements on an HTML form and respond to user events such as mouse clicks, form input, and page navigation.
* ''Server-side JavaScript'' extends the core language by supplying objects relevant to running JavaScript on a server. For example, server-side extensions allow an application to communicate with a relational database, provide continuity of information from one invocation to another of the application, or perform file manipulations on a server.

Through JavaScript's LiveConnect functionality, you can let Java and JavaScript code communicate with each other. From JavaScript, you can instantiate Java objects and access their public methods and fields. From Java, you can access JavaScript objects, properties, and methods.

Netscape invented JavaScript, and JavaScript was first used in Netscape browsers.

=JavaScript and Java=

JavaScript and Java are similar in some ways but fundamentally different in some others. The JavaScript language resembles Java but does not have Java's static typing and strong type checking. JavaScript follows most Java expression syntax, naming conventions and basic control-flow constructs which was the reason why it was renamed from LiveScript to JavaScript.

In contrast to Java's compile-time system of classes built by declarations, JavaScript supports a runtime system based on a small number of data types representing numeric, Boolean, and string values. JavaScript has a prototype-based object model instead of the more common class-based object model. The prototype-based model provides dynamic inheritance; that is, what is inherited can vary for individual objects. JavaScript also supports functions without any special declarative requirements. Functions can be properties of objects, executing as loosely typed methods.

JavaScript is a very free-form language compared to Java. You do not have to declare all variables, classes, and methods. You do not have to be concerned with whether methods are public, private, or protected, and you do not have to implement interfaces. Variables, parameters, and function return types are not explicitly typed.

Java is a class-based programming language designed for fast execution and type safety. Type safety means, for instance, that you can't cast a Java integer into an object reference or access private memory by corrupting Java bytecodes. Java's class-based model means that programs consist exclusively of classes and their methods. Java's class inheritance and strong typing generally require tightly coupled object hierarchies. These requirements make Java programming more complex than JavaScript programming.

In contrast, JavaScript descends in spirit from a line of smaller, dynamically typed languages such as HyperTalk and dBASE. These scripting languages offer programming tools to a much wider audience because of their easier syntax, specialized built-in functionality, and minimal requirements for object creation.

'''Table 1.1 JavaScript compared to Java'''
{{{!}}
! JavaScript
! Java
{{!}}-
{{!}} Object-oriented. No distinction between types of objects. Inheritance is through the prototype mechanism, and properties and methods can be added to any object dynamically.
{{!}} Class-based. Objects are divided into classes and instances with all inheritance through the class hierarchy. Classes and instances cannot have properties or methods added dynamically.
{{!}}-
{{!}} Variable data types are not declared (dynamic typing).
{{!}} Variable data types must be declared (static typing).
{{!}}-
{{!}} Cannot automatically write to hard disk.
{{!}} Cannot automatically write to hard disk.
{{!}}}


For more information on the differences between JavaScript and Java, see the chapter [[/guides/JavaScript/About_the_object_model|About the object model]].

=JavaScript and the ECMAScript Specification=

Netscape invented JavaScript, and JavaScript was first used in Netscape browsers. However, Netscape is working with Ecma International — the European association for standardizing information and communication systems (ECMA was formerly an acronym for the European Computer Manufacturers Association) to deliver a standardized, international programming language based on core JavaScript. This standardized version of JavaScript, called ECMAScript, behaves the same way in all applications that support the standard. Companies can use the open standard language to develop their implementation of JavaScript. The ECMAScript standard is documented in the ECMA-262 specification.

The ECMA-262 standard is also approved by the ISO (International Organization for Standardization) as ISO-16262. You can find a PDF version of ECMA-262 (outdated version) at the Mozilla website. You can also find the specification on the Ecma International website. The ECMAScript specification does not describe the Document Object Model (DOM), which is standardized by the World Wide Web Consortium (W3C). The DOM defines the way in which HTML document objects are exposed to your script.

==Relationship between JavaScript Versions and ECMAScript Editions==

Netscape worked closely with Ecma International to produce the ECMAScript Specification (ECMA-262). The following table describes the relationship between JavaScript versions and ECMAScript editions.

'''Table 1.2 JavaScript versions and ECMAScript editions'''
{{{!}}
! JavaScript version
! Relationship to ECMAScript edition
{{!}}-
{{!}} JavaScript 1.1
{{!}} ECMA-262, Edition 1 is based on JavaScript 1.1.
{{!}}-
{{!}} JavaScript 1.2
{{!}} ECMA-262 was not complete when JavaScript 1.2 was released. JavaScript 1.2 is not fully compatible with ECMA-262, Edition 1, for the following reasons: &lt;br&gt;(1) Netscape developed additional features in JavaScript 1.2 that were not considered for ECMA-262.
&lt;br&gt;(2) ECMA-262 adds two new features: internationalization using Unicode, and uniform behavior across all platforms. Several features of JavaScript 1.2, such as the Date object, were platform-dependent and used platform-specific behavior.
{{!}}-
{{!}} JavaScript 1.3
{{!}} JavaScript 1.3 is fully compatible with ECMA-262, Edition 1. &lt;br&gt;JavaScript 1.3 resolved the inconsistencies that JavaScript 1.2 had with ECMA-262, while keeping all the additional features of JavaScript 1.2 except == and !=, which were changed to conform with ECMA-262.
{{!}}-
{{!}} JavaScript 1.4
{{!}} JavaScript 1.4 is fully compatible with ECMA-262, Edition 1.&lt;br&gt;The third version of the ECMAScript specification was not finalized when JavaScript 1.4 was released.
{{!}}-
{{!}} JavaScript 1.5
{{!}} JavaScript 1.5 is fully compatible with ECMA-262, Edition 3.
{{!}}}

{{Note|ECMA-262, Edition 2 consisted of minor editorial changes and bug fixes to the Edition 1 specification. The  current release by the TC39 working group of Ecma International is ECMAScript Edition 5.1}}

The [[/js|JavaScript Reference]] indicates which features of the language are ECMAScript-compliant.

JavaScript will always include features that are not part of the ECMAScript Specification; JavaScript is compatible with ECMAScript, while providing additional features.

==JavaScript Documentation versus the ECMAScript Specification==

The ECMAScript specification is a set of requirements for implementing ECMAScript; it is useful if you want to determine whether a JavaScript feature is supported in other ECMAScript implementations. If you plan to write JavaScript code that uses only features supported by ECMAScript, then you may need to review the ECMAScript specification.

The ECMAScript document is not intended to help script programmers; use the JavaScript documentation for information on writing scripts.

==JavaScript and ECMAScript Terminology==

The ECMAScript specification uses terminology and syntax that may be unfamiliar to a JavaScript programmer. Although the description of the language may differ in ECMAScript, the language itself remains the same. JavaScript supports all functionality outlined in the ECMAScript specification.

The JavaScript documentation describes aspects of the language that are appropriate for a JavaScript programmer. For example:

* The Global Object is not discussed in the JavaScript documentation because you do not use it directly. The methods and properties of the Global Object, which you do use, are discussed in the JavaScript documentation but are called top-level functions and properties.
* The no parameter (zero-argument) constructor with the &lt;code&gt;Number&lt;/code&gt; and &lt;code&gt;String&lt;/code&gt; objects is not discussed in the JavaScript documentation, because what is generated is of little use. A &lt;code&gt;Number&lt;/code&gt; constructor without an argument returns +0, and a &lt;code&gt;String&lt;/code&gt; constructor without an argument returns &quot;&quot; (an empty string).

{{Compatibility_Section
|Not_required=No
|Desktop_rows=
|Mobile_rows=
|Notes_rows=
}}
{{See_Also_Section}}
{{Topics|JavaScript}}
{{External_Attribution
|Is_CC-BY-SA=Yes
|Sources=MDN
|MDN_link=https://developer.mozilla.org/en-US/docs/JavaScript/Guide/JavaScript_Overview
|MSDN_link=
|HTML5Rocks_link=
}}</text>
      <sha1>9iyp3jvjla2r3m8yctm3ltd6tps1g9w</sha1>
    </revision>
  </page>
</mediawiki>
MWXML;

        return new \SimpleXMLElement($xmlString);
    }
}
