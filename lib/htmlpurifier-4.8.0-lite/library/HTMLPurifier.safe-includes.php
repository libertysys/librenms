<?php

/**
 * @file
 * This file was auto-generated by generate-includes.php and includes all of
 * the core files required by HTML Purifier. This is a convenience stub that
 * includes all files using dirname(__FILE__) and require_once. PLEASE DO NOT
 * EDIT THIS FILE, changes will be overwritten the next time the script is run.
 *
 * Changes to include_path are not necessary.
 */

$__dir = dirname(__FILE__);

require_once $__dir . '/HTMLPurifier.php';
require_once $__dir . '/HTMLPurifier/Arborize.php';
require_once $__dir . '/HTMLPurifier/AttrCollections.php';
require_once $__dir . '/HTMLPurifier/AttrDef.php';
require_once $__dir . '/HTMLPurifier/AttrTransform.php';
require_once $__dir . '/HTMLPurifier/AttrTypes.php';
require_once $__dir . '/HTMLPurifier/AttrValidator.php';
require_once $__dir . '/HTMLPurifier/Bootstrap.php';
require_once $__dir . '/HTMLPurifier/Definition.php';
require_once $__dir . '/HTMLPurifier/CSSDefinition.php';
require_once $__dir . '/HTMLPurifier/ChildDef.php';
require_once $__dir . '/HTMLPurifier/Config.php';
require_once $__dir . '/HTMLPurifier/ConfigSchema.php';
require_once $__dir . '/HTMLPurifier/ContentSets.php';
require_once $__dir . '/HTMLPurifier/Context.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache.php';
require_once $__dir . '/HTMLPurifier/DefinitionCacheFactory.php';
require_once $__dir . '/HTMLPurifier/Doctype.php';
require_once $__dir . '/HTMLPurifier/DoctypeRegistry.php';
require_once $__dir . '/HTMLPurifier/ElementDef.php';
require_once $__dir . '/HTMLPurifier/Encoder.php';
require_once $__dir . '/HTMLPurifier/EntityLookup.php';
require_once $__dir . '/HTMLPurifier/EntityParser.php';
require_once $__dir . '/HTMLPurifier/ErrorCollector.php';
require_once $__dir . '/HTMLPurifier/ErrorStruct.php';
require_once $__dir . '/HTMLPurifier/Exception.php';
require_once $__dir . '/HTMLPurifier/Filter.php';
require_once $__dir . '/HTMLPurifier/Generator.php';
require_once $__dir . '/HTMLPurifier/HTMLDefinition.php';
require_once $__dir . '/HTMLPurifier/HTMLModule.php';
require_once $__dir . '/HTMLPurifier/HTMLModuleManager.php';
require_once $__dir . '/HTMLPurifier/IDAccumulator.php';
require_once $__dir . '/HTMLPurifier/Injector.php';
require_once $__dir . '/HTMLPurifier/Language.php';
require_once $__dir . '/HTMLPurifier/LanguageFactory.php';
require_once $__dir . '/HTMLPurifier/Length.php';
require_once $__dir . '/HTMLPurifier/Lexer.php';
require_once $__dir . '/HTMLPurifier/Node.php';
require_once $__dir . '/HTMLPurifier/PercentEncoder.php';
require_once $__dir . '/HTMLPurifier/PropertyList.php';
require_once $__dir . '/HTMLPurifier/PropertyListIterator.php';
require_once $__dir . '/HTMLPurifier/Queue.php';
require_once $__dir . '/HTMLPurifier/Strategy.php';
require_once $__dir . '/HTMLPurifier/StringHash.php';
require_once $__dir . '/HTMLPurifier/StringHashParser.php';
require_once $__dir . '/HTMLPurifier/TagTransform.php';
require_once $__dir . '/HTMLPurifier/Token.php';
require_once $__dir . '/HTMLPurifier/TokenFactory.php';
require_once $__dir . '/HTMLPurifier/URI.php';
require_once $__dir . '/HTMLPurifier/URIDefinition.php';
require_once $__dir . '/HTMLPurifier/URIFilter.php';
require_once $__dir . '/HTMLPurifier/URIParser.php';
require_once $__dir . '/HTMLPurifier/URIScheme.php';
require_once $__dir . '/HTMLPurifier/URISchemeRegistry.php';
require_once $__dir . '/HTMLPurifier/UnitConverter.php';
require_once $__dir . '/HTMLPurifier/VarParser.php';
require_once $__dir . '/HTMLPurifier/VarParserException.php';
require_once $__dir . '/HTMLPurifier/Zipper.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Clone.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Enum.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Integer.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Lang.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Switch.php';
require_once $__dir . '/HTMLPurifier/AttrDef/Text.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Number.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/AlphaValue.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Background.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/BackgroundPosition.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Border.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Color.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Composite.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/DenyElementDecorator.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Filter.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Font.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/FontFamily.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Ident.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/ImportantDecorator.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Length.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/ListStyle.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Multiple.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/Percentage.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/TextDecoration.php';
require_once $__dir . '/HTMLPurifier/AttrDef/CSS/URI.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Bool.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Nmtokens.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Class.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Color.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/FrameTarget.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/ID.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Pixels.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/Length.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/LinkTypes.php';
require_once $__dir . '/HTMLPurifier/AttrDef/HTML/MultiLength.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI/Email.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI/Host.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI/IPv4.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI/IPv6.php';
require_once $__dir . '/HTMLPurifier/AttrDef/URI/Email/SimpleCheck.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Background.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/BdoDir.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/BgColor.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/BoolToCSS.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Border.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/EnumToCSS.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/ImgRequired.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/ImgSpace.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Input.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Lang.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Length.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Name.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/NameSync.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Nofollow.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/SafeEmbed.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/SafeObject.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/SafeParam.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/ScriptRequired.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/TargetBlank.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/TargetNoreferrer.php';
require_once $__dir . '/HTMLPurifier/AttrTransform/Textarea.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Chameleon.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Custom.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Empty.php';
require_once $__dir . '/HTMLPurifier/ChildDef/List.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Required.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Optional.php';
require_once $__dir . '/HTMLPurifier/ChildDef/StrictBlockquote.php';
require_once $__dir . '/HTMLPurifier/ChildDef/Table.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache/Decorator.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache/Null.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache/Serializer.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache/Decorator/Cleanup.php';
require_once $__dir . '/HTMLPurifier/DefinitionCache/Decorator/Memory.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Bdo.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/CommonAttributes.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Edit.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Forms.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Hypertext.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Iframe.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Image.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Legacy.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/List.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Name.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Nofollow.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/NonXMLCommonAttributes.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Object.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Presentation.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Proprietary.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Ruby.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/SafeEmbed.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/SafeObject.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/SafeScripting.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Scripting.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/StyleAttribute.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tables.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Target.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/TargetBlank.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/TargetNoreferrer.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Text.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/XMLCommonAttributes.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/Name.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/Proprietary.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/XHTMLAndHTML4.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/Strict.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/Transitional.php';
require_once $__dir . '/HTMLPurifier/HTMLModule/Tidy/XHTML.php';
require_once $__dir . '/HTMLPurifier/Injector/AutoParagraph.php';
require_once $__dir . '/HTMLPurifier/Injector/DisplayLinkURI.php';
require_once $__dir . '/HTMLPurifier/Injector/Linkify.php';
require_once $__dir . '/HTMLPurifier/Injector/PurifierLinkify.php';
require_once $__dir . '/HTMLPurifier/Injector/RemoveEmpty.php';
require_once $__dir . '/HTMLPurifier/Injector/RemoveSpansWithoutAttributes.php';
require_once $__dir . '/HTMLPurifier/Injector/SafeObject.php';
require_once $__dir . '/HTMLPurifier/Lexer/DOMLex.php';
require_once $__dir . '/HTMLPurifier/Lexer/DirectLex.php';
require_once $__dir . '/HTMLPurifier/Node/Comment.php';
require_once $__dir . '/HTMLPurifier/Node/Element.php';
require_once $__dir . '/HTMLPurifier/Node/Text.php';
require_once $__dir . '/HTMLPurifier/Strategy/Composite.php';
require_once $__dir . '/HTMLPurifier/Strategy/Core.php';
require_once $__dir . '/HTMLPurifier/Strategy/FixNesting.php';
require_once $__dir . '/HTMLPurifier/Strategy/MakeWellFormed.php';
require_once $__dir . '/HTMLPurifier/Strategy/RemoveForeignElements.php';
require_once $__dir . '/HTMLPurifier/Strategy/ValidateAttributes.php';
require_once $__dir . '/HTMLPurifier/TagTransform/Font.php';
require_once $__dir . '/HTMLPurifier/TagTransform/Simple.php';
require_once $__dir . '/HTMLPurifier/Token/Comment.php';
require_once $__dir . '/HTMLPurifier/Token/Tag.php';
require_once $__dir . '/HTMLPurifier/Token/Empty.php';
require_once $__dir . '/HTMLPurifier/Token/End.php';
require_once $__dir . '/HTMLPurifier/Token/Start.php';
require_once $__dir . '/HTMLPurifier/Token/Text.php';
require_once $__dir . '/HTMLPurifier/URIFilter/DisableExternal.php';
require_once $__dir . '/HTMLPurifier/URIFilter/DisableExternalResources.php';
require_once $__dir . '/HTMLPurifier/URIFilter/DisableResources.php';
require_once $__dir . '/HTMLPurifier/URIFilter/HostBlacklist.php';
require_once $__dir . '/HTMLPurifier/URIFilter/MakeAbsolute.php';
require_once $__dir . '/HTMLPurifier/URIFilter/Munge.php';
require_once $__dir . '/HTMLPurifier/URIFilter/SafeIframe.php';
require_once $__dir . '/HTMLPurifier/URIScheme/data.php';
require_once $__dir . '/HTMLPurifier/URIScheme/file.php';
require_once $__dir . '/HTMLPurifier/URIScheme/ftp.php';
require_once $__dir . '/HTMLPurifier/URIScheme/http.php';
require_once $__dir . '/HTMLPurifier/URIScheme/https.php';
require_once $__dir . '/HTMLPurifier/URIScheme/mailto.php';
require_once $__dir . '/HTMLPurifier/URIScheme/news.php';
require_once $__dir . '/HTMLPurifier/URIScheme/nntp.php';
require_once $__dir . '/HTMLPurifier/URIScheme/tel.php';
require_once $__dir . '/HTMLPurifier/VarParser/Flexible.php';
require_once $__dir . '/HTMLPurifier/VarParser/Native.php';
