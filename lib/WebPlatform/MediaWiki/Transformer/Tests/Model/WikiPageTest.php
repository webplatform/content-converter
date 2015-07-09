<?php

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;


use WebPlatform\MediaWiki\Transformer\Model\WikiPage;
use WebPlatform\MediaWiki\Transformer\Model\Revision;
use \SimpleXMLElement;

/**
 * WikiPage test suite
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\WikiPage
 */
class WikiPageTest extends \PHPUnit_Framework_TestCase {

  /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
  protected $dumpBackupXml;

  public function setUp() {
    $dumpBackupXml = <<<'SAMPLE'
<mediawiki xmlns="http://www.mediawiki.org/xml/export-0.10/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.mediawiki.org/xml/export-0.10/ http://www.mediawiki.org/xml/export-0.10.xsd" version="0.10" xml:lang="en">
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
{{Related_Specifications_Section
|Specifications={{Related Specification
|Name=DOM Level 3 Events
|URL=http://www.w3.org/TR/DOM-Level-3-Events/
|Status=Working Draft
|Relevant_changes=Section 4.3
}}
}}
{{Topics|DOM, DOMEvents}}
</text>
      <sha1>2q4w9k2zrrdbrscx5u54a34utmjib0k</sha1>
    </revision>
    <revision>
      <id>39</id>
      <parentid>10</parentid>
      <timestamp>2012-06-20T04:42:18Z</timestamp>
      <contributor>
        <username>Shepazu</username>
        <id>2</id>
      </contributor>
      <comment>removed warning</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="1480">This Copyright Assignment Agreement (“Agreement”) is entered into between the participating entity contributing content to the WebPlatform.org site (“Contributor”), and the World Wide Web Consortium (&quot;W3C&quot;), represented through W3C Host MIT. This Agreement is effective as of the date content is submitted by Contributor (“Effective Date”).

Whereas, Contributor wishes to make available works created by Contributor and submitted for inclusion in the Web Platform Documentation Site (hereafter &quot;Site&quot;), collectively &quot;Contributions.&quot;

Whereas W3C, in conjunction with the other Stewards, wishes to host that material on the Site with public licenses that invite public use, royalty-free, and to be able to re-license such material if the needs of the Web Platform community change,

Therefore, Contributor agrees to assign and hereby assigns copyright in its Contributions to W3C, for issuance to the public royalty-free under a public license such as those meeting the Open Source Initiative’s Open Source Definition (http://opensource.org/docs/osd) or Creative Commons (http://creativecommons.org/licenses/) terms.

Contributor asserts that it has all rights necessary to assign its Contributions, and that their publication on the Site will not infringe the rights of others.

Contributor retains a non-exclusive, world-wide, perpetual license to reproduce, distribute, modify, publicly display, publicly perform, and publicly digitally perform its Contributions.</text>
      <sha1>l37t3nh9pz0qgiakt2o6v11ofw812jd</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:Doc Sprints</title>
    <ns>3000</ns>
    <id>8</id>
    <revision>
      <id>31893</id>
      <parentid>31892</parentid>
      <timestamp>2013-05-07T18:57:47Z</timestamp>
      <contributor>
        <username>Jswisher</username>
        <id>8</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="3074">We have ongoing documentation sprints to work on integrating the content on the WebPlatform.org site. There are many benefits to getting people together in physically for this sort of work, both for effective collaboration and for community-building.

==Schedule==
See (and probably &quot;watch&quot;) the [http://docs.webplatform.org/wiki/WPD:Community/Community_Events Community Events page].

==Logistics==
A virtual sprint can be organized on fairly short notice–participants just need to commit and clear their schedules. An in-person sprint requires more lead time and logistics. We're working on extending this document to a Web Platform Doc Sprint in-a-Box document for more information on how to organize an in-person Doc Sprint.

==Planning Guide==
Janet Swisher started a [https://developer.mozilla.org/Project:en/Doc_sprint_planning_guide Doc Sprint planning guide].

There is also the [http://booki.flossmanuals.net/book-sprints/_draft/_v/1.0/introduction/ FLOSS Manuals Book Sprints book]; it's only available in draft form, because Adam Hyde considers it out of date with regard to his current philosophy on book sprints, but it should be helpful as far as the practical issues.

==Organizer Roles==
There should be at least two roles for organizers in a sprint: one person to organize the logistics, and another to facilitate the content effort. A single person doing both is too draining.

===Logistics Organizer===
This person should manage the budget and funding, find a location, identify participants, arrange meals, and so on.

===Content Facilitator===
This person should facilitate the content effort by guiding the creation and review of different materials, and encouraging collaboration between participants.

====Recommended Facilitators====
Janet recommend Adam Hyde of FLOSS Manuals, as he has more experience at this than really anybody. (even though we won't be using FLOSS Manuals site or producing a &quot;book&quot; per se). Contact Janet for an introduction to Adam.

==Participants==
We want at best one representative from each steward organization, along with community volunteers; otherwise, we risk filling the room with stewards and excluding community.

==Materials==

'''Doc Sprint dashboard''': There is a dashboard available that helps to monitor Doc Sprint results and inspires people to keep the momentum over the event. It fetches the Media Wiki API for latest changes and narrows down the data based on a given list of usernames (== Doc Sprint participants) and timeframe, which is then visualized in configurably graphs and leaderboards. Grab the code here: https://github.com/webplatform/DocSprintDashboard

'''Doc Sprint slide template''': We have uploaded the presentation slides used at the Berlin Doc Sprint in February 2013, for you to reuse or base your own presentations on:

* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.key Keynote]
* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.ppt Powerpoint]
* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.pdf PDF]</text>
      <sha1>56iivsqehag14u3gqytjz2sdm99kn5s</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:Infrastructure/proposals/Site Map</title>
    <ns>3000</ns>
    <id>16</id>
    <revision>
      <id>62561</id>
      <parentid>62555</parentid>
      <timestamp>2014-07-11T15:53:33Z</timestamp>
      <contributor>
        <username>Renoirb</username>
        <id>10080</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="5129">
{{Note|This page describes the initial plan for webplatform.org, most content is deprecated}}

===Content===
* Reference docs
* Guides
* Tutorials

===Content===
?

===Software===
* ✓ pastebin
* ✓ live code tester
** ✓ [http://dabblet.com/ Dabblet]
* ✓ live DOM viewer
* ✓ validation</text>
      <sha1>rwkog8qa38dfz0xxdafe39qovsfp1q7</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:CSS Example Article</title>
    <ns>3000</ns>
    <id>198</id>
    <redirect title="WPD:Example Pages/CSS" />
    <revision>
      <id>613</id>
      <timestamp>2012-08-15T12:36:14Z</timestamp>
      <contributor>
        <username>Jkomoros</username>
        <id>9</id>
      </contributor>
      <comment>Jkomoros moved page [[WPD:CSS Example Article]] to [[WPD:Example Pages/CSS]]: Restructuring because we have multiple example pages</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="35">#REDIRECT [[WPD:Example Pages/CSS]]</text>
      <sha1>lqlzcylbs46x6npcmscfxsywdkzxdyc</sha1>
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
SAMPLE;
    $this->dumpBackupXml = simplexml_load_string($dumpBackupXml);
  }

  protected function stdout($text) {
    fwrite(STDOUT, $text . "\n");
  }

  /**
   * @covers ::getTitle
   */
  public function testTitle() {
    $pageNode = $this->dumpBackupXml->page[0];
    $title = (string) $pageNode->title;
    $obj = new WikiPage($pageNode);
    $this->assertSame($title, $obj->getTitle());
  }

  /**
   * @covers ::revisions
   */
  public function testRevisions() {
    $pageNode = $this->dumpBackupXml->page[0];
    $count = count($pageNode->revision);
    $obj = new WikiPage($pageNode);
    $this->assertSame($count, $obj->getRevisions()->count());
  }

  /**
   * @covers ::latest
   */
  public function testLatestTimestampFormat() {
    // Made sure we have at least 2 revisions in SAMPLE
    // dumpBackupXml, and that the timestamp of the first item
    // is the following.
    $latestTimestamp = '2014-08-20T17:41:27Z';
    $obj = new WikiPage($this->dumpBackupXml->page[0]);
    $objTimestamp = $obj->getLatest()->getTimestamp()->format('Y-m-d\TH:i:sT');
    $this->assertSame($latestTimestamp, $objTimestamp);
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevision() {
    $obj = new WikiPage($this->dumpBackupXml->page[0]);
    $this->assertInstanceOf('\WebPlatform\MediaWiki\Transformer\Model\Revision', $obj->getLatest());
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevisionDateTime() {
    $obj = new WikiPage($this->dumpBackupXml->page[0]);
    $this->assertInstanceOf('\DateTime', $obj->getLatest()->getTimestamp());
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevisionRevisionsType() {
    $obj = new WikiPage($this->dumpBackupXml->page[0]);
    $this->assertInstanceOf('\SplDoublyLinkedList', $obj->getRevisions());
  }

  /**
   * @covers ::latest
   */
  public function testRevisionOrderingListContributors() {
    // Made sure we have at least 2 revisions in SAMPLE
    // dumpBackupXml, and that the the contributors usernames
    // are in order.
    $hardcodedContributors = 'Dgash,Shepazu';
    $obj = new WikiPage($this->dumpBackupXml->page[0]);
    $stack = $obj->getRevisions();
    $stack->rewind();
    $contributors = array();
    while($stack->valid()){
        $contributors[] = $stack->current()->getContributor();
        $stack->next();
    }
    $this->assertSame(join($contributors,','), $hardcodedContributors);

  }

  /**
   * @covers ::hasRedirect
   */
  public function testHasRedirect(){
    $pageNode = $this->dumpBackupXml->page;

    // We know that only the page[3] has a redirect
    $non_redir = new WikiPage($pageNode[1]);
    $redirected = new WikiPage($pageNode[3]);

    $this->assertFalse($non_redir->hasRedirect());
    $this->assertTrue($redirected->hasRedirect());
  }

  /**
   * @covers ::getRedirect
   *
   * We want to get the potential name of the redirect
   * so we know which file to refer to.
   */
  public function testGetRedirect(){
    // pageNode[3] has <redirect title="WPD:Example Pages/CSS" />
    // lets expect we get a string similar to "WPD/Example-Pages/CSS"
    $redirected = new WikiPage($this->dumpBackupXml->page[3]);

    $this->assertSame($redirected->getRedirect(), "WPD:Example Pages/CSS");
  }

 }
