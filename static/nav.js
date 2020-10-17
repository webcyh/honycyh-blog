var bg = document.getElementById('bg');
var box = document.getElementsByClassName('box');

var tag = true;
/**
 * 变换函数个数不同时候 也不会触发transition 函数位置不一样也不会触发
 * @return {[type]} [description]
 *
 * 等截面加载完成再添加动画 否则无效
 */
window.onload = function(){
    function fn(){
        //动画为旋转以及缩放 因为结束以及 因为开始与结束要一致 所以这里设置为1
        this.style.transform = "rotate(720deg) scale(1)";
        this.style.opacity = 1;
        this.style.transition="3s";
        //解除动画结束事件
        this.removeEventListener('transitionend',fn)
    }
    //给每个里边元素添加点击事件旋转并且缩放 动画结束后再次回归 注意这里的tramsform的个数以及顺序应该一致否则下次无法使用
    for(var i=0;i<box.length;i++){
        box[i].onmouseover= function(){
            this.style.transform = "rotate(-720deg) scale(2)";
            this.style.opacity = 0.1;
            this.style.transition="0.5s";
            this.addEventListener('transitionend',fn)
        }
    }
    //点击大盒子时候 先判断当前的 状态为开启或者 关闭
    bg.onclick = function(){
        if(tag){
            //旋转345
            bg.style.transform = "rotate(345deg)";
            tag = false;
            //遍历里边的内容并且里边的也相应的做出变化旋转
            for(var i=0;i<box.length;i++){
                box[i].style.transform = "rotate(720deg) scale(1)";
                //设置延迟时间
                box[i].style.transition = '0.5s '+(i*0.1)+'s';
                box[i].style.left = -get(i*22.5).left+'px';
                box[i].style.top = -get(i*22.5).top+'px';
            }
        }else{
            //关闭时候设置为
            bg.style.transform = "rotate(0deg)";
            for(var i=0;i<box.length;i++){
                //即使这里的scale(1)为1也应该设置否则因为 个数不同无法触发transition事件
                box[i].style.transform = "rotate(0deg) scale(1)";
                box[i].style.transition = '0.5s '+((5-i)*0.1)+'s';
                box[i].style.left = '0px';
                box[i].style.top = '0px';
            }
            tag = true
        }
    }


    function get(deg){
        /**
         * x:sin(deg)*length
         * y:cos(deg)*legnth
         */
        return {

            left:Math.round(Math.sin(Math.PI*deg/180)*140),
            top:Math.round(Math.cos(Math.PI*deg/180)*140)
        }
    }
}