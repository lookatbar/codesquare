import React, { Component, cloneElement } from 'react';
import { connect } from 'react-redux';
import { routeMap } from '../routes';
import ReactCSSTransitionGroup from 'react/lib/ReactCSSTransitionGroup';
import Loading from './common/Loading';

// import { initWX } from './appRedux';

// @todo 
// 根据路由 修改标题
// 基础资源引入

@connect()
class App extends Component {
  componentDidMount(){
    // 设置标题
    const { location, dispatch } = this.props;
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
    const { routes } = this.props

    let key;

    try{
      key = routes[1].path;
    }catch(error){
      return null;
    }

    return (
      <div className="App">
        <ReactCSSTransitionGroup
          transitionName="routeTransitionWrapper"
          transitionEnter={true}
          transitionEnterTimeout={500}
          transitionLeave={true}
          transitionLeaveTimeout={500}
          component="div"
          className="routeTransitionWrapper">
          { cloneElement(this.props.children, {key: key}) }
        </ReactCSSTransitionGroup>
        <Loading />
      </div>
    );
  }
}

export default App;
