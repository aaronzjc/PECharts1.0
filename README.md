## PECharts
后端封装一层ECharts的接口，方便用户生成配置项和其他一些操作。刚开始开发中。

## 主要目的
目前构思的开发模式是后端返回Option配置项的JSON给前端，前端进行展示。所以，做这个的目的是考虑怎么友好的生成这么一个Option数组的JSON数据。

因为JSON可以对应于PHP中的数组,所以问题就转化为怎么简单优雅的构造这么一个数组.说起数组构造,马上就想起了之前看过的Monga的框架的.MongoDB的查询
语句是JSON格式,原生的PHP扩展是使用数组作为参数查询.然后Monga就利用闭包构造了一个漂亮的查询结构.当初看到这里时,确实让人眼前一亮.所以,当想到这么
一个问题时,马上就想到了Monga.相比Monga,我这个只是一个toy,格式也不同.但是,不妨碍做这么一个东西.

其次，开发这个还会补丁一些后端开发中，会遇到困难的地方。让困难不困难。

## v 0.0.1
最最最基础的一个版本.主要是实现了一个简单的数组构造器.暂时没有测试用例,没有文档,啥都没有.

传统的数组构造是如下的方式 

    $option = [
        'title' => [
            'show' => True,
            'text' => '图例'
        ],
        'legend' => [
            'data' => [[...], [...]]
        ],
        'series' => [
            [...],
            [...],
        ]
    ];

如果数组十分的庞大之后,显得逻辑十分混乱,需要时刻保证数组的格式.所以,做了这么一个小东西,可以用十分semantic的方式构造这么一个数组:

    $option->title(function($title){
    
        $title->show = true;
        $title->text = '图例';
    
    })->legend(function($legend){
    
        $legend->data = [...];
        // 或
        $legend->data(function($data){
            ...
        }, true);
    
    })->series(function($series){
    
        // ... 
    
    }, true)->series(function($series){
       
        // ...
    
    }, true);
    
v 0.0.1就做了上面这么一个东西.还做了一些其他的,不过那就和实际应用比较紧密了.

暂时自己写着玩玩吧.毕竟成熟的东西需要经过实践的考验.反复应用,测试之后才能发现是否对实际的项目有帮助,还是仅仅只是多此一举.