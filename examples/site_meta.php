<?php

/**
 * SiteMeta - 站点元信息管理
 * 
 * 用于管理网站的基础信息，并提供友好的文本描述生成能力。
 */

class SiteMeta
{
    private $title;
    private $description;
    private $keywords;
    private $author;
    private $url;
    private $language;
    private $favicon;
    private $themeColor;

    private static $defaultConfig = [
        'title'       => '爱游戏',
        'description' => '爱游戏是一个专注于游戏资讯与社区交流的平台',
        'keywords'    => ['爱游戏', '游戏', '资讯', '社区'],
        'author'      => '爱游戏团队',
        'url'         => 'https://appportal-i-game.com.cn',
        'language'    => 'zh-CN',
        'favicon'     => '/favicon.ico',
        'themeColor'  => '#1e90ff',
    ];

    public function __construct(array $config = [])
    {
        $merged = array_merge(self::$defaultConfig, $config);

        $this->title       = $merged['title'];
        $this->description = $merged['description'];
        $this->keywords    = $merged['keywords'];
        $this->author      = $merged['author'];
        $this->url         = $merged['url'];
        $this->language    = $merged['language'];
        $this->favicon     = $merged['favicon'];
        $this->themeColor  = $merged['themeColor'];
    }

    /**
     * 生成站点描述文本
     *
     * @param string $format 可选：short / full / meta
     * @return string
     */
    public function generateDescription($format = 'short')
    {
        switch ($format) {
            case 'full':
                return sprintf(
                    '%s - %s。关键词：%s。网址：%s',
                    $this->title,
                    $this->description,
                    implode('、', $this->keywords),
                    $this->url
                );
            case 'meta':
                return sprintf(
                    '<meta name="description" content="%s">',
                    htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8')
                );
            case 'short':
            default:
                return sprintf(
                    '%s - %s',
                    $this->title,
                    mb_substr($this->description, 0, 30)
                );
        }
    }

    /**
     * 以数组形式返回所有元信息
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'keywords'    => $this->keywords,
            'author'      => $this->author,
            'url'         => $this->url,
            'language'    => $this->language,
            'favicon'     => $this->favicon,
            'themeColor'  => $this->themeColor,
        ];
    }

    /**
     * 生成一个简单的 HTML 页面头部示例
     *
     * @return string
     */
    public function renderHtmlHead()
    {
        $escapedTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $escapedDesc  = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $escapedUrl   = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $keywordsStr  = htmlspecialchars(implode(', ', $this->keywords), ENT_QUOTES, 'UTF-8');

        return <<<HTML
<title>{$escapedTitle}</title>
<meta charset="utf-8">
<meta name="description" content="{$escapedDesc}">
<meta name="keywords" content="{$keywordsStr}">
<meta name="author" content="{$escapedTitle}">
<link rel="canonical" href="{$escapedUrl}">
HTML;
    }

    /**
     * 从预设数组创建实例（工厂方法）
     *
     * @param string $siteName
     * @return self
     */
    public static function createFromPreset($siteName = 'game')
    {
        $presets = [
            'game' => [
                'title'       => '爱游戏',
                'description' => '爱游戏 - 最新游戏资讯与玩家社区',
                'keywords'    => ['爱游戏', '游戏资讯', '玩家社区', '手游', '端游'],
                'url'         => 'https://appportal-i-game.com.cn',
            ],
            'blog' => [
                'title'       => '技术博客',
                'description' => '分享编程与互联网技术的个人博客',
                'keywords'    => ['技术', '编程', '博客'],
                'url'         => 'https://example.com/blog',
            ],
        ];

        $config = $presets[$siteName] ?? $presets['game'];
        return new self($config);
    }
}

// 使用示例
$meta = SiteMeta::createFromPreset('game');

echo $meta->generateDescription('short') . "\n";
echo $meta->generateDescription('full') . "\n";
echo $meta->generateDescription('meta') . "\n";
echo $meta->renderHtmlHead() . "\n";