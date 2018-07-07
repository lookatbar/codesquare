import React, { Component, cloneElement } from 'react';
import { routeMap } from '../routes';
import ReactCSSTransitionGroup from 'react/lib/ReactCSSTransitionGroup';

// @todo 
// 根据路由 修改标题
// 基础资源引入

class App extends Component {
  componentDidMount(){
    const { location } = this.props;
    Object.keys(routeMap).forEach(route => {
      if(location.pathname.match(route)){
        document.title = routeMap[route];
      }
    });
  }

  componentWillReceiveProps({location}){
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

    const key = routes[1].path;

    return (
      <ReactCSSTransitionGroup
        transitionName="routeTransitionWrapper"
        transitionEnter={true}
        transitionEnterTimeout={500}
        transitionLeave={true}
        transitionLeaveTimeout={500}
        component="div"
        className="App routeTransitionWrapper">
        { cloneElement(this.props.children, {key: key}) }
      </ReactCSSTransitionGroup>
    );
  }
}

export default App;
