import React, { Component, cloneElement } from 'react';
import { routeMap } from '../routes';
import ReactCSSTransitionGroup from 'react/lib/ReactCSSTransitionGroup';

// @todo 
// 根据路由 修改标题
// 基础资源引入

class App extends Component {
  componentDidMount(){
    const { location } = this.props;
    document.title = routeMap[location.pathname];
  }

  componentWillReceiveProps({location}){
    if(location.pathname !== this.props.location.pathname){
      document.title = routeMap[location.pathname];
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
        className="App">
        { cloneElement(this.props.children, {key: key}) }
      </ReactCSSTransitionGroup>
    );
  }
}

export default App;
