import './styles/main.less';
import R from 'ramda';
import { createStore, combineReducers, applyMiddleware } from 'redux';

const { __READLINKS_STATE__ } = global;

createStore(
    combineReducers({
        posts: R.compose(R.identity, R.defaultTo({}))
    }),
    __READLINKS_STATE__,
    applyMiddleware(

    )
);
