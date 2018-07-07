import React, { Component } from 'react';
import { connect } from 'react-redux';
import { routeMap } from '../routes';
// import ReactCSSTransitionGroup from 'react/lib/ReactCSSTransitionGroup';
import Loading from './common/Loading';

// import { initWX } from './appRedux';

// @todo 
// 根据路由 修改标题
// 基础资源引入

@connect()
class App extends Component {
  componentDidMount(){
    // 设置标题
    const { location } = this.props;
    Object.keys(routeMap).forEach(route => {
      if(location.pathname.match(route)){
        document.title = routeMap[route];
      }
    });
    // 获取票据并缓存
    // dispatch( initWX() );
  }

  componentWillReceiveProps({location}){
    // 设置标题
    if(location.pathname !== this.props.location.pathname){
      Object.keys(routeMap).forEach(route => {
        if(location.pathname.match(route)){
          document.title = routeMap[route];
        }
      });
    }
  }

  render() {
    return (
      <div className="App">
        { this.props.children }
        <Loading />
      </div>
    );
  }
}

export default App;
