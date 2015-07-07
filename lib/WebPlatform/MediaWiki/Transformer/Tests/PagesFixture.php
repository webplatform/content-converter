<?php

namespace WebPlatform\MediaWiki\Transformer\Tests;

class PagesFixture {

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
    $xmlString = <<<MWXML
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
</mediawiki>
MWXML;

    return simplexml_load_string($xmlString);
  }
}
