import React, { Component } from 'react';
import PropTypes from 'prop-types';

class AToDoService extends Component {
    static defaultProps = {
        anotherdefault : 'anotherdefault'
    }
    static propTypes = {
        anotherdefault : PropTypes.string
    }
    render() {
        return (
            <div>
                AToDoService [{this.props.name}]
                <p/>[[{this.props.namedefault}]]
                <p/>[[{this.props.anotherdefault}]]
            </div>
        );
    }
}
AToDoService.defaultProps = {
    namedefault: 'namedefault'
}
export default AToDoService;