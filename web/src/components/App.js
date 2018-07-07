import React, { Component } from 'react';
import { routeMap } from '../routes';

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
    return (
      <div className="App">
        { this.props.children }
      </div>
    );
  }
}

export default App;
